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
                <a href="{{ route('dashboard.parsing.add') }}" class="btn btn-primary">Add parsing</a>
            </div>

            <div class="card">
                <div class="table-responsive">

                    <table class="table mb-0">
                        <thead class="table-light text-uppercase">
                        <tr>
                            <th>#</th>
                            <th>Domain</th>
                            <th>Query</th>
                            <th>Language</th>
                            <th>Country</th>
                            <th>From/To</th>
                            <th>Sort</th>
                            <th>Limit</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($parser->count() > 0)
                            @foreach($parser as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>
                                        @if($item->domain)
                                            {{ $item->domain->host }}
                                        @else
                                            ---
                                        @endif
                                    </td>
                                    <td>
                                        {{ $item->query }}
                                    </td>
                                    <td>
                                        {{ $item->language }}
                                    </td>
                                    <td>
                                        {{ $item->country }}
                                    </td>
                                    <td>
                                        @if($item->from_at)
                                            <span class="px-1">{{ $item->from_at->format('d/m/Y') }}</span>
                                        @endif

                                        @if($item->to_at)
                                            <span class="px-1">{{ $item->to_at->format('d/m/Y') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $item->sort_by }}
                                    </td>
                                    <td>
                                        {{ $item->limit }}
                                    </td>
                                    <td>
                                        <div class="form-text">
                                            {{ $item->updated_at->format('d/m/Y H:i') }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($item->active)
                                            <div class="badge bg-success">active</div>
                                        @else
                                            <div class="badge bg-warning text-dark">hold</div>
                                        @endif
                                    </td>
                                    <td align="right">
                                        <a href="{{ route('dashboard.parsing.edit', $item->id) }}" class="btn btn-primary btn-sm mx-1">Edit</a>
                                        <form action="{{ route('dashboard.parsing.delete', $item->id) }}" method="post" class="d-inline-block my-2" @submit="onDelete($event)">
                                            @csrf
                                            @method('delete')

                                            <button type="submit" class="btn btn-outline-danger btn-sm mx-1">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="10" align="center">Not found items</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>

                </div>
            </div>

            {{ $parser->links() }}

        </div>
    </section>
@endsection
