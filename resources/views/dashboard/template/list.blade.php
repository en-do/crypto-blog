@extends('layouts.dashboard')

@section('content')
    <section>
        <div class="container">

            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="button mb-4 text-end">
                <a href="{{ route('dashboard.template.add') }}" class="btn btn-primary">Add template</a>
            </div>

            <div class="card">
                <div class="table-responsive">

                    <table class="table mb-0">
                        <thead class="table-light text-uppercase">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            @can('template-all')
                                <th>Author</th>
                            @endcan
                            <th>Vars</th>
                            <th>Meta</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($templates->count() > 0)
                            @foreach($templates as $template)
                                <tr>
                                    <td>{{ $template->id }}</td>
                                    <td>
                                        @if($template->image)
                                            <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline>
                                            </svg>
                                        @endif

                                        <a href="{{ route('dashboard.template.view', $template->id) }}" target="_blank" class="fw-bold">{{ $template->title }}</a>
                                    </td>
                                    @can('template-all')
                                        <td>
                                            <div class="badge bg-primary fw-bold">{{ $template->user->name }}</div>
                                        </td>
                                    @endcan
                                    <td>{{ $template->countVars() }}</td>
                                    <td>
                                        @if($template->meta_title && $template->meta_description)
                                            <div class="badge bg-success">true</div>
                                        @else
                                            <div class="badge bg-warning text-dark">false</div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="form-text">
                                            @if($template->updated_at)
                                                {{ $template->updated_at->format('d/m/Y H:i') }}
                                            @else
                                                --
                                            @endif
                                        </div>
                                    </td>
                                    <td align="right">
                                        <a href="{{ route('dashboard.template.save', $template->id) }}" class="btn btn-outline-secondary btn-sm mx-1" @click="onPush()">Push post</a>
                                        <a href="{{ route('dashboard.template.view', $template->id) }}" class="btn btn-warning text-dark btn-sm mx-1">View</a>
                                        <a href="{{ route('dashboard.template.edit', $template->id) }}" class="btn btn-primary btn-sm mx-1">Edit</a>
                                        <form action="{{ route('dashboard.template.delete', $template->id) }}" method="post" class="d-inline-block" @submit="onDelete()">
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

            {{ $templates->links() }}

        </div>
    </section>
@endsection
