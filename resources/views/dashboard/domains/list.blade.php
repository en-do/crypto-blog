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
                <a href="{{ route('dashboard.domain.add') }}" class="btn btn-primary">Add domain</a>
            </div>

            <div class="card">
                <div class="table-responsive">

                    <table class="table mb-0">
                        <thead class="table-light text-uppercase">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Theme</th>
                                <th>Host</th>
                                <th>Meta</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($domains->count() > 0)
                                @foreach($domains as $domain)
                                    <tr>
                                        <td>{{ $domain->id }}</td>
                                        <td>{{ $domain->title }}</td>
                                        <td>
                                            <div class="badge bg-primary">{{ $domain->template }}</div>
                                        </td>
                                        <td>{{ $domain->host }}</td>
                                        <td>
                                            @if($domain->meta && $domain->meta->title && $domain->meta->description)
                                                <div class="badge bg-success">true</div>
                                            @else
                                                <div class="badge bg-warning text-dark">false</div>
                                            @endif
                                        </td>
                                        <td>
                                            @switch($domain->status)
                                                @case('draft')
                                                    <div class="badge bg-secondary">draft</div>
                                                    @break
                                                @case('published')
                                                    <div class="badge bg-success">published</div>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>
                                            <div class="form-text">
                                                @if($domain->updated_at)
                                                    {{ $domain->updated_at->format('d/m/Y H:i') }}
                                                @else
                                                    --
                                                @endif
                                            </div>
                                        </td>
                                        <td align="right">
                                            <a href="{{ route('dashboard.domain.edit', $domain->id) }}" class="btn btn-primary btn-sm">Edit</a>
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

            {{ $domains->links() }}

        </div>
    </section>
@endsection
