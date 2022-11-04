<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Post;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function home() {
        $template = resolve('template');
        $domain_id = resolve('domain_id');


        $domain = Domain::findOrFail($domain_id);

        $tops = Post::whereHas('domains', function($q) use($domain_id) {
            $q->where('domain_id', $domain_id);
        })->whereStatus('published')->orderBy('view', 'desc')->limit(3)->get();

        $posts = Post::whereHas('domains', function($q) use($domain_id) {
            $q->where('domain_id', $domain_id);
        })->whereStatus('published')->orderBy('created_at', 'desc')->paginate(10);

        $ticker = Post::whereHas('domains', function($q) use($domain_id) {
            $q->where('domain_id', $domain_id);
        })->whereStatus('published')->inRandomOrder()->orderBy('created_at', 'desc')->limit(12)->get();

        $latest = Post::whereHas('domains', function($q) use($domain_id) {
            $q->where('domain_id', $domain_id);
        })->whereStatus('published')->orderBy('created_at', 'desc')->limit(3)->get();

        return view("templates.$template.home", compact('domain', 'ticker', 'tops', 'latest', 'posts'));
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\View
     */
    public function post($slug) {
        $template = resolve('template');
        $domain_id = resolve('domain_id');

        $single = Post::whereHas('domains', function($q) use($domain_id) {
            $q->where('domain_id', $domain_id);
        })->whereStatus('published')->where('slug', $slug)->firstOrFail();

        $related = Post::whereHas('domains', function($q) use($domain_id) {
            $q->where('domain_id', $domain_id);
        })->whereStatus('published')->whereNotIn('id', [$single->id])->inRandomOrder()->limit(3)->get();

        $single->update([
            'view' => $single->view + 1
        ]);

        return view("templates.$template.post", compact('single', 'related'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function search(Request $request) {
        $template = resolve('template');
        $domain_id = resolve('domain_id');

        $title = $request->q;

        $posts = Post::whereHas('domains', function($q) use($domain_id) {
            $q->where('domain_id', $domain_id);
        })->where('title', 'LIKE', "%$title%")->whereStatus('published')->paginate(10);

        return view("templates.$template.search", compact('posts'));
    }
}
