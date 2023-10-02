<?php

namespace App\Console\Commands;

use App\Models\Parsing;
use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use App\Services\Traits\UploadImage;
use App\Services\Traits\ParsingArticle;

class getPosts extends Command
{
    use UploadImage, ParsingArticle;

    protected $url;
    protected $api_key;
    protected $timeout;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parsing:posts {item_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get posts to api and save';

    public function __construct()
    {
        parent::__construct();

        $this->url = 'https://newsomaticapi.com/apis/news/v1/all';
        $this->api_key = env('API_KEY');
        $this->timeout = 20;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $item_id = $this->argument('item_id') ?? null;

        if(isset($item_id)) {
            $item = Parsing::where('active', 1)->find($item_id);

            if(isset($item->id)) {
                $posts = $this->request($item);
                $count_posts = count($posts);

                //dd($posts);

                //$this->line("posts: $count_posts");

                if ($count_posts > 0) {
                    foreach ($posts as $post) {
                        $this->savePost($post, $item->domain_id);
                    }
                }
            }

            $this->error('This parsing item not found');
            exit();
        }

        if(empty($item_id)) {
            $items = Parsing::where('active', 1)->get();

            //print_r($items);

            if($items->count() > 0) {
                foreach ($items as $item) {
                    $posts = $this->request($item);
                    $count_posts = count($posts);

                    //dd($posts);

                    //$this->line("posts: $count_posts");

                    if ($count_posts > 0) {
                        foreach ($posts as $post) {

                            //print_r( $this->getContent($post['url']) );
                            $this->savePost($post, $item->domain_id);
                        }
                    }
                }

                exit();
            }

            $this->error('This parsing items not found');
            exit();
        }
    }

    public function savePost($item, $domain_id) {
        $post = Post::where('title', $item['title'])->first();
        $post_url = $item['url'] ?? null;

        $content = $this->getContent($post_url);

        if($content) {
            if (!isset($post->id)) {
                $post = new Post;

                $post->user_id = 1;
                $post->title = $item['title'];

                if ($post_url) {
                    $post->content = trim($content);
                } else {
                    $post->content = $item['content'];
                }

                $post->slug = Str::of($item['title'])->slug('-');

                if (isset($item['urlToImage'])) {
                    if (@file_get_contents($item['urlToImage'])) {
                        $post->image = $this->uploadImage($item['urlToImage'], "images/source/post", $post->slug, 100, false);
                    }
                }

                $post->view = rand(10, 1000);
                $post->order = 0;
                $post->status = 'published';

                if ($post->saveOrfail()) {
                    $post->domains()->attach($domain_id);

                    $post->meta()->create([
                        'title' => $item['title'],
                        'description' => $item['description'] ?? null,
                        'no_index' => 0
                    ]);

                    $id = $post->id;

                    $this->line("post url: $post_url");
                    $this->info("post ID $id created");
                }
            } else {
                $id = $post->id;
                $this->line("post url: $post_url");
                $this->line("post ID $id have exists title");
            }
        } else {
            $this->line("post url: $post_url");
            $this->line("secure posts");
        }
    }

    public function request($item) {
        $query = $item->query;

        $date_from = $item->from_at ?? null;
        $date_to = $item->to_at ?? null;
        $language = $item->language;
        $country = $item->country;
        $sort = $item->sort;
        $limit = $item->limit;
        $page = 1;

        $data = [
            'apikey' => $this->api_key,
            'q' => $query,
            'language' => $language,
            'sortBy' => $sort,
            'page' => $page,
            'pageSize' => $limit
        ];

        if($country) {
            $data['country'] = $country;
        }

        if ($date_from) {
            $data['from'] = $date_from->format('Y-m-d');
        }

        if ($date_to) {
            $data['to'] = $date_to->format('Y-m-d');
        }

        $this->line("timeout: $this->timeout");

        $send = Http::connectTimeout($this->timeout)->get($this->url, $data);

        if ($send->successful()) {
            //Log::info($send->json());

            return $send->json('articles');
        }

        if ($send->json('error')) {
            $this->error($send->json('error'));

            exit();
        }
    }
}
