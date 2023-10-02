@extends('layouts.dashboard')

@section('content')
    <section>
        <div class="container">

            <form action="{{ route('dashboard.parsing.create') }}" method="post">
                @csrf
                @method('post')

                <div class="card mb-4">
                    <div class="card-body">

                        <div class="mb-4">
                            <label for="" class="form-label">Domain</label>
                            <select name="domain" class="form-select @error('domain') is-invalid @enderror" id="">
                                @foreach($domains as $domain)
                                    <option value="{{ $domain->id }}" @selected(old('domain') == $domain->id)>{{ $domain->id }} - {{ $domain->host }}</option>
                                @endforeach
                            </select>

                            @error('domain')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div class="mb-4">
                            <label for="" class="form-label">Query</label>
                            <input type="text" name="query" class="form-control @error('query') is-invalid @enderror" value="{{ old('query') }}" minlength="3" required>

                            @error('query')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="" class="form-label">Language</label>
                            <input type="text" name="language" class="form-control @error('language') is-invalid @enderror" value="{{ old('language') ?? 'en' }}" minlength="2" maxlength="2">

                            <div class="form-text">Default: <b>en</b></div>

                            @error('language')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="" class="form-label">Country</label>
                            <input type="text" name="country" class="form-control @error('country') is-invalid @enderror" value="{{ old('country') ?? 'en' }}" minlength="2" maxlength="2">

                            <div class="form-text">Default: <b>en</b></div>

                            @error('country')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="" class="form-label">From date</label>
                            <input type="date" name="from_at" class="form-control @error('from_at') is-invalid @enderror" value="{{ old('from_at') }}">

                            @error('from_at')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="" class="form-label">To date</label>
                            <input type="date" name="to_at" class="form-control @error('to_at') is-invalid @enderror" value="{{ old('to_at') }}">

                            @error('to_at')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="" class="form-label">Sort</label>
                            <select name="sort" class="form-select @error('sort') is-invalid @enderror" id="">
                                <option value="relevancy">relevancy</option>
                                <option value="popularity">popularity</option>
                                <option value="publishedAt">publishedAt</option>
                                <option value="random">random</option>
                            </select>

                            @error('sort')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="" class="form-label">Limit</label>
                            <input type="number" name="limit" class="form-control @error('limit') is-invalid @enderror" value="{{ old('limit') ?? 10 }}" min="8" step="1">

                            <div class="form-text">The count of posts to parsing.  Deafult: 10</div>

                            @error('limit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="status" class="form-label">Status</label>
                            <select name="active" id="status" class="form-select">
                                <option value="1">Active</option>
                                <option value="0">Hold</option>
                            </select>

                            @error('active')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>
                </div>


                <div class="button text-end mt-4">
                    <button type="submit" class="btn btn-primary">Save setting</button>
                </div>
            </form>

        </div>
    </section>
@endsection
