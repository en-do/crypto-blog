@extends('layouts.dashboard')

@section('content')
    <section>
        <div class="container">

            <form action="{{ route('dashboard.template.create') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('post')

                <div class="card mb-4">
                    <div class="card-body">

                        @if($template->image)
                            <div class="text-center bg-light">
                                <img src="{{ $template->image }}" width="420" alt="" class="img-fluid">
                            </div>
                        @endif

                        <div class="mb-4">
                            <label for="" class="form-label">Image</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">

                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        @can('template-author')
                            <div class="mb-4">
                                <label for="" class="form-label">Author</label>
                                <select name="author" class="form-select @error('author') is-invalid @enderror" id="">
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" @selected($user->id == $template->user_id)>{{ $user->id }} - {{ $user->name }}</option>
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
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" minlength="6" required>

                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="" class="form-label">Vars</label>
                            <add-code-component :list="{{ json_encode($template->vars) }}"></add-code-component>
                        </div>

                        <div class="mb-4">
                            <label for="" class="form-label">Content</label>
                            <editor-component content="{{ old('description') ?? $template->content }}"></editor-component>

                            @error('description')
                                <span class="invalid-feedback d-inline-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="" class="form-label">Slug</label>
                            <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') ?? $template->slug }}" minlength="6">

                            @error('slug')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <hr>

                    <div class="card-body">
                        <div class="mb-4">
                            <label for="" class="form-label">Order</label>
                            <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" min="0" step="1" value="{{ old('order') ?? $template->order }}">

                            @error('order')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">

                        <div class="mb-4">
                            <label for="" class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control @error('meta_title') is-invalid @enderror" value="{{ old('meta_title') ?? $template->meta_title }}" minlength="6">

                            @error('meta_title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="" class="form-label">Meta Description</label>
                            <input type="text" name="meta_description" class="form-control @error('meta_description') is-invalid @enderror" value="{{ old('meta_description') ?? $template->meta_description }}">

                            @error('meta_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="button text-end mt-4">
                    <div class="row">
                        <div class="col-6 text-start">
                            <a href="{{ route('dashboard.template.view', $template->id) }}" target="_blank" class="btn btn-warning text-dark me-2">Preview</a>
                            <a href="{{ route('dashboard.template.save', $template->id) }}" class="btn btn-outline-secondary" @click="onPush()">Push post</a>
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary">Save template</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </section>
@endsection
