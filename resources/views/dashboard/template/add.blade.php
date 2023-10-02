@extends('layouts.dashboard')

@section('content')
    <section>
        <div class="container">

            <form action="{{ route('dashboard.template.create') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('post')

                <div class="card mb-4">
                    <div class="card-body">

                        <div class="mb-4">
                            <label for="" class="form-label">Image</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" required>

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
                                        <option value="{{ $user->id }}">{{ $user->id }} - {{ $user->name }}</option>
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
                            <add-code-component></add-code-component>
                        </div>

                        <div class="mb-4">
                            <label for="" class="form-label">Content</label>
                            <editor-component content="{{ old('description') }}"></editor-component>

                            @error('description')
                                <span class="invalid-feedback d-inline-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>

                    <hr>

                    <div class="card-body">

                        <div class="mb-4">
                            <label for="" class="form-label">Slug</label>
                            <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" minlength="6">

                            @error('slug')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    @can('template-author')
                        <div class="mb-4">
                            <label for="" class="form-label">Order</label>
                            <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" min="0" step="1" value="{{ old('order') ?? 0 }}" >

                            @error('order')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    @endcan

                    </div>
                </div>

                <div class="card">
                    <div class="card-body">

                        <div class="mb-4">
                            <label for="" class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control @error('meta_title') is-invalid @enderror" value="{{ old('meta_title') }}" minlength="6">

                            @error('meta_title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="" class="form-label">Meta Description</label>
                            <input type="text" name="meta_description" class="form-control @error('meta_description') is-invalid @enderror" value="{{ old('meta_description') }}">

                            @error('meta_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="button text-end mt-4">
                    <button type="submit" class="btn btn-primary">Save template</button>
                </div>
            </form>

        </div>
    </section>
@endsection
