<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

use App\Models\Domain;
use App\Models\Post;
use App\Models\User;

use App\Services\Traits\UploadImage;


class PostController extends Controller
{
    use UploadImage;

    public string $path_image = "images/post";

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function list(Request $request) {
        $post = Post::query();

        if($request->filled('q')) {
            $title = $request->q;
            $post->where('title', 'like', "%$title%");
        }

        if(auth()->user()->cannot('post-all')) {
            $post->where('user_id', Auth::id());
        }

        $posts = $post->paginate(10);

        return view('dashboard.posts.list', compact('posts'));
    }

    /**
     * @param $post_id
     * @return \Illuminate\Contracts\View\View
     */
    public function view($post_id) {
        $post = Post::findOrFail($post_id);

        return view('dashboard.posts.view', compact('post'));
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function add() {
        if(auth()->user()->can('post-domain')) {
            $users = User::all();
            $domains = Domain::whereStatus('published')->get();

            return view('dashboard.posts.add', compact('users', 'domains'));
        } else {
            $domains = Auth::user()->permission;

            return view('dashboard.posts.add', compact('domains'));
        }
    }

    /**
     * @param $post_id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($post_id) {
        $post = Post::findOrFail($post_id);


        if(auth()->user()->cannot('post-update', $post)) {
            abort(403);
        }

        if(auth()->user()->can('post-domain')) {
            $domains = Domain::whereStatus('published')->get();
            $users = User::all();

            return view('dashboard.posts.edit', compact('post','users', 'domains'));
        } else {
            $domains = Auth::user()->permission;

            return view('dashboard.posts.edit', compact('post','domains'));
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function create(Request $request) {
        $request->validate([
            'author' => ['required'],
            'domain.*' => ['required', 'numeric'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
            'title' => ['required', 'min:6', 'max:255'],
            'description' => ['required', 'min:6'],
            'slug' => ['nullable', 'min:6', 'max:255', 'unique:posts'],
            'order' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:published,draft,moderation']
        ]);

        $post = new Post;

        if(auth()->user()->can('post-author')) {
            if ($request->filled('author')) {
                $post->user_id = $request->author;
            } else {
                $post->user_id = Auth::id();
            }
        }

        $post->image = $request->image;
        $post->title = $request->title;

        $post->content = $request->description;

        if($request->hasFile('image')) {
            $image = $request->file('image');

            $post->image = $this->uploadImage($image, $this->path_image, $post->slug);
        }

        if($request->filled('slug')) {
            $post->slug = Str::of($request->slug)->slug('-');
        } else {
            $post->slug = Str::slug($request->title);
        }

        $post->view = $request->view;
        $post->order = $request->order;
        $post->status = $request->status;

        if($post->saveOrfail()) {
            if($request->filled('domain')) {
                $post->domains()->attach($request->domain);
            }

            $post->meta()->create([
                'title' => $request->meta_title ?? $request->title,
                'description' => $request->meta_description ?? null,
                'no_index' => $request->index ?? 0
            ]);

            return redirect()->route('dashboard.posts')->with('success', 'Post created');
        }
    }

    /**
     * @param Request $request
     * @param $post_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $post_id) {
        $request->validate([
            'author' => ['required', 'numeric'],
            'domain.*' => ['required', 'numeric'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
            'title' => ['required', 'string', 'min:6', 'max:255'],
            'description' => ['required', 'min:6'],
            'slug' => ['nullable', 'min:6', 'max:255', 'unique:posts,slug,' . $post_id],
            'order' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'string', 'in:published,draft,moderation']
        ]);

        $post = Post::findOrFail($post_id);

        if(auth()->user()->cannot('post-update', $post)) {
            abort(403);
        }

        if(auth()->user()->can('post-author')) {
            if ($request->filled('author')) {
                $post->user_id = $request->author;
            } else {
                $post->user_id = Auth::id();
            }
        }

        $post->image = $request->image;
        $post->title = $request->title;

        $post->content = $request->description;

        if($request->hasFile('image')) {
            $image = $request->file('image');

            $post->image = $this->uploadImage($image, $this->path_image, $post->slug);
        }

        if($request->filled('slug')) {
            $post->slug = Str::of($request->slug)->slug('-');
        } else {
            $post->slug = Str::slug($request->title);
        }

        $post->view = $request->view;
        $post->order = $request->order;
        $post->status = $request->status;

        if($post->saveOrfail()) {
            if($request->filled('domain')) {
                $post->domains()->sync($request->domain);
            }

            $post->meta()->update([
                'title' => $request->meta_title ?? $request->title,
                'description' => $request->meta_description ?? null,
                'no_index' => $request->index ?? 0
            ]);

            return redirect()->route('dashboard.posts')->with('success', 'Post updated');
        }
    }

    /**
     * @param $post_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($post_id) {
        $post = Post::findOrFail($post_id);

        if(auth()->user()->cannot('post-delete', $post)) {
            abort(403);
        }

        if($post->delete()) {
            return redirect()->route('dashboard.posts')->with('success', 'Post deleted');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request) {
        $validator = Validator::make($request->all(), [
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048']
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors()], 422);
        }

        $upload_image = $request->file('image');


        $image = $this->uploadImage($upload_image, "images/post", null, 65);

        if ($image) {
            return response(['image' => $image], 200);
        }

        return response(['error' => "Error let's try that again"], 422);
    }
}
