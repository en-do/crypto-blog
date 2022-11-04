@extends('layouts.dashboard')

@section('content')
    <section>
        <div class="container">

            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="row">
                <div class="col-12 col-md-10">
                    <form method="get">
                        <div class="input-group mb-0">
                            <input type="text" class="form-control" name="q" placeholder="Search title" aria-label="search" value="{{ request('q') }}">
                            <button class="btn btn-outline-primary" type="submit" id="button-addon2">Search</button>
                        </div>
                    </form>
                </div>

                <div class="col-12 col-md-2">
                    <div class="button mb-4 text-end">
                        <a href="{{ route('dashboard.post.add') }}" class="btn btn-primary">Add post</a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="table-responsive">

                    <table class="table mb-0">
                        <thead class="table-light text-uppercase">
                        <tr>
                            <th>#</th>
                            @can('post-all')
                                <th>Author</th>
                            @endcan
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Domain</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($posts->count() > 0)
                            @foreach($posts as $post)
                                <tr>
                                    <td>{{ $post->id }}</td>
                                    @can('post-all')
                                        <td>
                                            @if($post->user)
                                                <div class="badge bg-primary fw-bold">{{ $post->user->name }}</div>
                                            @endif
                                        </td>
                                    @endcan
                                    <td>
                                        @if($post->image)
                                            <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline>
                                            </svg>
                                        @endif

                                        <a href="{{ route('dashboard.post.view', $post->id) }}" target="_blank" class="fw-bold">{{ $post->title }}</a>
                                    </td>
                                    <td>{{ $post->slug }}</td>
                                    <td>
                                        @if($post->domains->count() > 0)
                                            @foreach($post->domains as $domain)
                                                <div class="fw-bold">{{ $domain->host }}</div>
                                            @endforeach
                                        @else
                                            --
                                        @endif
                                    </td>
                                    <td>
                                        {{ $post->status }}
                                    </td>
                                    <td>
                                        <div class="form-text">
                                            {{ $post->updated_at }}
                                        </div>
                                    </td>
                                    <td align="right">
                                        <a href="{{ route('dashboard.post.view', $post->id) }}" class="btn btn-warning text-dark btn-sm mx-1">View</a>
                                        <a href="{{ route('dashboard.post.edit', $post->id) }}" class="btn btn-primary btn-sm mx-1">Edit</a>
                                        <form action="{{ route('dashboard.post.delete', $post->id) }}" method="post" class="d-inline-block" @submit="onDelete()">
                                            @csrf
                                            @method('delete')

                                            <button type="submit" class="btn btn-outline-danger btn-sm mx-1">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" align="center">Not found items</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>

                </div>
            </div>

            {{ $posts->links() }}

        </div>
    </section>
@endsection
