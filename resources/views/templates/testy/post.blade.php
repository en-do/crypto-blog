@extends('templates.testy.layout')

@section('title', $single->meta->title ?? null)
@section('description', $single->meta->description ?? null)
@section('no_index', $single->meta->no_index ?? false)

@section('content')
    @include('templates.testy.header')

    <main class="pt-4">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('domain.home') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $single->title }}</li>
                </ol>
            </nav>

            <h1>{{ $single->title }}</h1>

            @if($single->image)
                <div class="pb-4">
                    <img src="{{ $single->image }}" alt="{{ $single->title }}" class="img-fluid">
                </div>
            @endif

            <div>
                {!! $single->content !!}
            </div>

            <div class="pt-3 mt-4">
                <div class="row">
                    <div class="col-6">
                        <b>{{ $single->created_at->format('d.m.Y') }}</b>
                    </div>
                    <div class="col-6 text-end">
                        view: {{ $single->view }}
                    </div>
                </div>
            </div>

            <hr>

            <div class="pt-5">
                <h2>You may have missed</h2>

                <div class="row pt-3">
                    @if($related->count() > 0)
                        <div class="row">
                            @foreach($related as $post)
                                <div class="col-12 col-md-4">
                                    <a href="{{ route('domain.post', $post->slug) }}" class="card mb-4">
                                        <div class="image">
                                            <img src="{{ $post->image }}" alt="" class="img-fluid">
                                        </div>

                                        <div class="card-body">
                                            <h5>{{ $post->title }}</h5>

                                            {{ \Str::of(strip_tags($post->content))->words(100, '...') }}
                                        </div>

                                        <span class="card-footer">
                                        {{ $post->created_at->format('d.m.Y') }}
                                    </span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection
