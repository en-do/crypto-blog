@extends('layouts.dashboard')

@section('content')
    <main class="pt-4">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $post->title }}</li>
                </ol>
            </nav>

            <h1>{{ $post->title }}</h1>

            @if($post->image)
                <div class="pb-4">
                    <img src="{{ $post->image }}" alt="" class="img-fluid">
                </div>
            @endif

            <div>
                {!! $post->content !!}
            </div>

            <div class="pt-3 mt-4">
                <div class="row">
                    <div class="col-6">
                        <b>{{ $post->created_at->format('d.m.Y') }}</b>
                    </div>
                    <div class="col-6 text-end">
                        view: {{ $post->view }}
                    </div>
                </div>
            </div>


        </div>
    </main>
@endsection
