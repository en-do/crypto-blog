@extends('layouts.dashboard')

@section('content')
    <section>
        <div class="container">

            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="button text-end mb-4">
                <a href="{{ route('dashboard.user.add') }}" class="btn btn-primary">Add user</a>
            </div>

            <div class="card">
                <div class="table-responsive">

                    <table class="table mb-0">
                        <thead class="table-light text-uppercase">
                            <tr>
                                <th>#</th>
                                <th>Role</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Expired</th>
                                <th>Domains</th>
                                <th>Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($users->count() > 0)
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>
                                            @if($user->role)
                                                {{ $user->role->title }}
                                            @endif
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <div class="form-text">
                                                @if($user->expired_at)
                                                    {{ $user->expired_at->format('d/m/Y') }}
                                                @else
                                                    --
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @if($user->permission->count() > 0)
                                                @foreach($user->permission as $domain)
                                                    <div class="fw-bold">({{ $domain->id }}) {{ $domain->host }}</div>
                                                @endforeach
                                            @else
                                                --
                                            @endif
                                        </td>
                                        <td>
                                            <div class="form-text">
                                                {{ $user->updated_at->format('d/m/Y H:i') }}
                                            </div>
                                        </td>
                                        <td align="right">
                                            <a href="{{ route('dashboard.user.edit', $user->id) }}" class="btn btn-primary btn-sm">edit</a>
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

            {{ $users->links() }}

        </div>
    </section>
@endsection
