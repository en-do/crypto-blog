@extends('layouts.dashboard')

@section('content')
    <section>
        <div class="container">

            <form action="{{ route('dashboard.user.update', $user->id) }}" method="post">
                @csrf
                @method('put')

                <div class="card">
                    <div class="card-body">

                        <div class="mb-4">
                            <label for="" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') ?? $user->name }}">

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') ?? $user->email }}">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="" class="form-label">Domains</label>

                            @foreach($domains as $key => $domain)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="domain[]" value="{{ $domain->id }}" id="{{ $domain->host }}" @checked($user->checkedDomain($domain->id))>
                                    <label class="form-check-label" for="{{ $domain->host }}">
                                        {{ $domain->host }}
                                    </label>
                                </div>
                            @endforeach

                            @error('domain')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4 mt-4">
                            <label for="" class="form-label">Expired Date</label>
                            <input type="date" name="expired" class="form-control @error('expired') is-invalid @enderror" value="{{ old('expired') ?? $user->expired_at ? $user->expired_at->format('Y-m-d') : ''  }}">

                            @error('expired')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="" class="form-label">New Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="button text-end mt-4">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>

        </div>
    </section>
@endsection
