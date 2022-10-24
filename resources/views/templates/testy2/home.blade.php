@extends('templates.testy.layout')

@section('content')
    @include('templates.testy.header')

    <main class="pt-4">
        <div class="container">
            <h1>testy 2</h1>

            @if($ticker->count() > 0)
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="ticker">
                            <div class="wrap">
                                @foreach($ticker as $item)
                                    <a href="{{ route('domain.post', $item->slug) }}" class="d-inline-block fw-bold">{{ $item->title }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <hr>

            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="row">
                        @foreach($tops as $post)
                            <div class="col-12 col-md-4">
                                <a href="{{ route('domain.post', $post->slug) }}" class="card mb-4">
                                    <div class="image">
                                        <img src="{{ $post->image }}" alt="" class="img-fluid">
                                    </div>

                                    <div class="card-body">
                                        <h5>{{ $post->title }}</h5>

                                        {{  \Str::limit($post->content, 150) }}
                                    </div>

                                    <div class="card-footer">
                                        {{ $post->created_at->format('d.m.Y') }}
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item text-center w-50" role="presentation">
                            <button class="nav-link w-100 active" data-bs-toggle="pill" data-bs-target="#latest" type="button" role="tab" aria-controls="latest" aria-selected="true">Latest</button>
                        </li>
                        <li class="nav-item text-center w-50" role="presentation">
                            <button class="nav-link w-100" data-bs-toggle="pill" data-bs-target="#popular" type="button" role="tab" aria-controls="popular" aria-selected="false">Popular</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="latest" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                            @foreach($latest as $post)
                                <a href="{{ route('domain.post', $post->slug) }}" class="card mb-4">
                                    <div class="card-body">
                                        <h5>{{ $post->title }}</h5>
                                    </div>

                                    <div class="card-footer">
                                        {{ $post->created_at->format('d.m.Y') }}
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <div class="tab-pane fade" id="popular" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                            @foreach($tops as $post)
                                <a href="{{ route('domain.post', $post->slug) }}" class="card mb-4">
                                    <div class="card-body">
                                        <h5>{{ $post->title }}</h5>
                                    </div>

                                    <div class="card-footer">
                                        {{ $post->created_at->format('d.m.Y') }}
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>

            <hr>

            <div class="pt-4">

                @if($posts->count() > 0)
                    <div class="row">
                        @foreach($posts as $post)
                            <div class="col-12 col-md-6">
                                <a href="{{ route('domain.post', $post->slug) }}" class="card mb-4">
                                    <div class="image">
                                        <img src="{{ $post->image }}" alt="" class="img-fluid">
                                    </div>

                                    <div class="card-body">
                                        <h5>{{ $post->title }}</h5>

                                        {{  \Str::limit($post->content, 150) }}
                                    </div>

                                    <span class="card-footer">
                                        {{ $post->created_at->format('d.m.Y') }}
                                    </span>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    {{ $posts->links() }}
                @else
                    <div class="alert bg-warning">Items not found</div>
                @endif

            </div>
        </div>
    </main>
@endsection
