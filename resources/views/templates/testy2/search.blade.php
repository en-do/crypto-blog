@extends('templates.testy.layout')

@section('content')
    @include('templates.testy.header')

    <main class="pt-4">
        <div class="container">
            <h1>testy 2</h1>

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
