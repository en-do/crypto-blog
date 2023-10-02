@extends('layouts.dashboard')

@section('content')
    <section>
        <div class="container">

            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('dashboard.post.update', $post->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')

                <div class="card mb-4">
                    @if($post->image)
                        <div class="text-center bg-light">
                            <img src="{{ $post->image }}" width="420" alt="" class="img-fluid">
                        </div>
                    @endif

                    <div class="card-body">

                        <div class="mb-4">
                            <label for="" class="form-label">Image</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">

                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="" class="form-label">Domains</label>

                            @foreach($domains as $key => $domain)
                                <div class="form-check @error('domain') is-invalid @enderror">
                                    <input class="form-check-input" type="checkbox" name="domain[{{ $domain->id }}]" value="{{ $domain->id }}" id="{{ $domain->host }}" @checked($post->checkedDomain($domain->id))>
                                    <label class="form-check-label" for="{{ $domain->host }}">
                                        {{ $domain->host }}
                                    </label>
                                </div>
                            @endforeach

                            @error('domain')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        @can('post-author')
                            <div class="mb-4">
                                <label for="" class="form-label">Author</label>
                                <select name="author" class="form-select @error('author') is-invalid @enderror" id="">
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" @selected($user->id == $post->user_id)>{{ $user->id }} - {{ $user->name }}</option>
                                    @endforeach
                                </select>

                                @error('author')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        @endcan


                        <div class="mb-4">
                            <label for="" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') ?? $post->title }}" minlength="6" required>

                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="" class="form-label">Content</label>

                            <editor-component content="{{ old('description') ?? $post->content }}"></editor-component>

                            @error('description')
                                <span class="invalid-feedback d-inline-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="" class="form-label">Slug</label>
                            <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') ?? $post->slug }}" minlength="6">

                            @error('slug')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    @can('post-view')
                        <hr>

                        <div class="card-body">

                            <div class="mb-4">
                                <label for="" class="form-label">View</label>
                                <input type="number" name="view" class="form-control @error('view') is-invalid @enderror" min="0" step="1" value="{{ old('view') ?? $post->view }}">

                                @error('view')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="" class="form-label">Order</label>
                                <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" min="0" step="1" value="{{ old('order') ?? $post->order }}">

                                @error('order')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="mb-4">
                                <label for="" class="form-label">Status</label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" id="">
                                    <option value="published" @selected($post->status == 'published')>published</option>
                                    <option value="draft" @selected($post->status == 'draft')>draft</option>
                                    <option value="moderation" @selected($post->status == 'moderation')>moderation</option>
                                </select>

                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    @endcan
                </div>

                <div class="card">
                    <div class="card-body">

                        <div class="mb-4">
                            <label for="" class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control @error('meta_title') is-invalid @enderror" value="{{ old('meta_title') ?? $post->meta->title }}" minlength="6">

                            @error('meta_title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="" class="form-label">Meta Description</label>
                            <input type="text" name="meta_description" class="form-control @error('meta_description') is-invalid @enderror" value="{{ old('meta_description') ?? $post->meta->description }}">

                            @error('meta_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 col-md-6 text-start">
                        <a href="{{ route('dashboard.post.view', $post->id) }}" target="_blank" class="btn btn-warning text-dark">View</a>
                    </div>

                    <div class="col-12 col-md-6 text-end ">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>

            </form>

        </div>
    </section>
@endsection
