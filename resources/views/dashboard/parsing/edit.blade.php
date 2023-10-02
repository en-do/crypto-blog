@extends('layouts.dashboard')

@section('content')
    <section>
        <div class="container">

            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach

            <form action="{{ route('dashboard.parsing.update', $parsing->id) }}" method="post">
                @csrf
                @method('put')

                <div class="card mb-4">
                    <div class="card-body">

                        <div class="mb-4">
                            <label for="" class="form-label">Domain</label>
                            <select name="domain" class="form-select @error('domain') is-invalid @enderror" id="">
                                @foreach($domains as $domain)
                                    <option value="{{ $domain->id }}" @selected($parsing->domain_id == $domain->id)>{{ $domain->id }} - {{ $domain->host }}</option>
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
                            <input type="text" name="query" class="form-control @error('query') is-invalid @enderror" value="{{ old('query') ?? $parsing->query }}" minlength="3" required>

                            @error('query')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="" class="form-label">Language</label>
                            <input type="text" name="language" class="form-control @error('language') is-invalid @enderror" value="{{ old('language') ?? $parsing->language }}" minlength="2" maxlength="2">

                            <div class="form-text">Default: <b>en</b></div>

                            @error('language')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="" class="form-label">Country</label>
                            <input type="text" name="country" class="form-control @error('country') is-invalid @enderror" value="{{ old('country') ?? $parsing->country }}" minlength="2" maxlength="2">

                            <div class="form-text">Default: <b>en</b></div>

                            @error('country')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="" class="form-label">From date</label>
                            <input type="date" name="from_at" class="form-control @error('from_at') is-invalid @enderror" value="{{ old('from_at') ?? $parsing->from_at }}">

                            @error('from_at')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="" class="form-label">To date</label>
                            <input type="date" name="to_at" class="form-control @error('to_at') is-invalid @enderror" value="{{ old('to_at') ?? $parsing->to_at }}">

                            @error('to_at')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="" class="form-label">Sort</label>
                            <select name="sort" class="form-select @error('sort') is-invalid @enderror" id="">
                                <option value="relevancy" @selected($parsing->sort == 'relevancy')>relevancy</option>
                                <option value="popularity" @selected($parsing->sort == 'popularity')>popularity</option>
                                <option value="publishedAt" @selected($parsing->sort == 'publishedAt')>publishedAt</option>
                                <option value="random" @selected($parsing->sort == 'random')>random</option>
                            </select>

                            @error('sort')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="" class="form-label">Limit</label>
                            <input type="number" name="limit" class="form-control @error('limit') is-invalid @enderror" value="{{ old('limit') ?? $parsing->limit }}" min="1" step="1">

                            <div class="form-text">The count of posts to parsing.  Deafult: 100</div>

                            @error('limit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="status" class="form-label">Status</label>
                            <select name="active" id="status" class="form-select">
                                <option value="1" @selected($parsing->active == 1)>Active</option>
                                <option value="0" @selected($parsing->active == 0)>Hold</option>
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
