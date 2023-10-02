@extends('layouts.dashboard')

@section('content')
    <section>
        <div class="container">

        @can('dashboard-admin')
            <div class="row">
                <div class="col-12 col-md-4">

                    <div class="card">
                        <div class="card-body">
                            <h4 class="fw-bold">Post</h4>
                            <div class="badge bg-primary">{{ $post_count }}</div>
                        </div>
                    </div>

                </div>

                <div class="col-12 col-md-4">

                    <div class="card">
                        <div class="card-body">
                            <h4 class="fw-bold">Users</h4>
                            <div class="badge bg-primary">{{ $user_count }}</div>
                        </div>
                    </div>

                </div>

                <div class="col-12 col-md-4">

                    <div class="card">
                        <div class="card-body">
                            <h4 class="fw-bold">Domain</h4>
                            <div class="badge bg-primary">{{ $domain_count }}</div>
                        </div>
                    </div>

                </div>
            </div>

        @else
                <div class="card">
                    <div class="card-body">
                        <h6 class="fw-bold">Expired date</h6>
                        {{ auth()->user()->expired_at->format('d/m/Y') ?? 'no limits' }}
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="table-responsive">

                        <table class="table mb-0">
                            <thead class="table-light fw-bold text-uppercase">
                                <tr>
                                    <th>#</th>
                                    <th>Domain</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if($domains->count() > 0)
                                @foreach($domains as $domain)
                                    <tr>
                                        <td>{{ $domain->id }}</td>
                                        <td class="fw-bold">{{ $domain->host }}</td>
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
        @endcan

        </div>
    </section>
@endsection
