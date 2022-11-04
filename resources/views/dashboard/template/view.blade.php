@extends('layouts.dashboard')

@section('content')
    <main class="pt-4">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $template->title }}</li>
                </ol>
            </nav>

            <h1>{{ $template->title }}</h1>

            @if($template->image)
                <div class="pb-4">
                    <img src="{{ $template->image }}" alt="" class="img-fluid">
                </div>
            @endif

            <div>
                {!! $template->getContent() !!}
            </div>

            <div class="pt-3 mt-4">
                <div class="row">
                    <div class="col-6">
                        <b>{{ $template->created_at->format('d.m.Y') }}</b>
                    </div>
                    <div class="col-6 text-end">
                        view: {{ $template->view }}
                    </div>
                </div>
            </div>


        </div>
    </main>
@endsection
