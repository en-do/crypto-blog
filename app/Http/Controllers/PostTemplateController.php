<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Services\Traits\UploadImage;
use Illuminate\Http\Request;
use App\Models\PostTemplate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use SebastianBergmann\Template\Template;

class PostTemplateController extends Controller
{
    use UploadImage;

    public string $path_image = "images/post/template";

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function list() {
        $template = PostTemplate::query();

        if(auth()->user()->cannot('template-all')) {
            $template->where('user_id', Auth::id());
        }

        $templates = $template->paginate(10);

        return view('dashboard.template.list', compact('templates'));
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function add() {
        $users = User::all();

        return view('dashboard.template.add', compact('users'));
    }

    /**
     * @param $template_id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($template_id) {
        $template = PostTemplate::findOrFail($template_id);
        $users = User::all();

        return view('dashboard.template.edit', compact('template', 'users'));
    }

    /**
     * @param $template_id
     * @return \Illuminate\Contracts\View\View
     */
    public function view($template_id) {
        $template = PostTemplate::findOrFail($template_id);

        return view('dashboard.template.view', compact('template'));
    }

    /**
     * @param Post $post
     * @param $template_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Post $post, $template_id) {
        $template = PostTemplate::findOrFail($template_id);

        $post->title = $template->title;
        $post->user_id = $template->user_id;
        $post->image = $template->image;
        $post->slug = $template->slug;

        $post->content = $this->getContent($template->vars, $template->content);

        if($post->save()) {
            $post->meta()->create([
                'title' => $request->meta_title ?? $template->title,
                'description' => $request->meta_description ?? null,
                'no_index' => $request->index ?? 0
            ]);

            return redirect()->route('dashboard.templates')->with('success', 'Template published');
        }

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request) {
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
            'title' => ['required', 'min:6', 'max:255'],
            'option' => ['required'],
            'description' => ['required', 'min:6'],
            'slug' => ['nullable', 'min:6', 'max:255', 'unique:posts']
        ]);

        $template = new PostTemplate;

        if($request->filled('author')) {
            $template->user_id = $request->author;
        } else {
            $template->user_id = Auth::id();
        }

        $template->title = $request->title;
        $template->content = $request->description;



        if($request->filled('slug')) {
            $template->slug = Str::of($request->slug)->slug('-');
        } else {
            $template->slug = Str::slug($request->title);
        }

        if($request->hasFile('image')) {
            $image = $request->file('image');

            $template->image = $this->uploadImage($image, $this->path_image, $template->slug);
        }

        if($request->filled('option')) {
            $options = array();

            foreach ($request->option as $option) {
                $option = explode("|", $option);

                $options[] = array(
                    'code' => $option[0],
                    'value' => $option[1]
                );
            }

            $template->vars = json_encode($options);
        }


        if($template->save()) {
            return redirect()->route('dashboard.templates')->with('success', 'Template created');
        }
    }

    /**
     * @param Request $request
     * @param $template_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $template_id) {
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
            'title' => ['required', 'min:6', 'max:255'],
            'option' => ['required'],
            'description' => ['required', 'min:6'],
            'slug' => ['nullable', 'min:6', 'max:255', 'unique:posts,slug,'. $template_id]
        ]);

        $template = PostTemplate::findOrFail($template_id);

        if($request->filled('author')) {
            $template->user_id = $request->author;
        } else {
            $template->user_id = Auth::id();
        }

        $template->title = $request->title;
        $template->content = $request->description;



        if($request->filled('slug')) {
            $template->slug = Str::of($request->slug)->slug('-');
        } else {
            $template->slug = Str::slug($request->title);
        }

        if($request->hasFile('image')) {
            $image = $request->file('image');

            $template->image = $this->uploadImage($image, $this->path_image, $template->slug);
        }

        if($request->filled('option')) {
            $options = array();

            foreach ($request->option as $option) {
                $option = explode("|", $option);

                $options[] = array(
                    'code' => $option[0],
                    'value' => $option[1]
                );
            }

            $template->vars = json_encode($options);
        }


        if($template->save()) {
            return redirect()->route('dashboard.templates')->with('success', 'Template created');
        }
    }

    /**
     * @param $template_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($template_id) {
        $template = PostTemplate::findOrFail($template_id);

        if($template->delete()) {
            return redirect()->route('dashboard.templates')->with('success', 'Template deleted');
        }
    }

    /**
     * @param $vars
     * @param $content
     * @return mixed|string
     */
    private function getContent($vars, $content) {
        $vars = json_decode($vars);

        foreach ($vars as $var) {
            $replaced = Str::replace(":$var->code:", $var->value, $content);

            $content = $replaced;
        }

        return $content;
    }
}
