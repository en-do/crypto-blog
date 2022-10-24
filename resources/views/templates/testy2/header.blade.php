<header class="navbar navbar-expand-lg navbar-light bd-navbar sticky-top" style="background-color: #e3f2fd;">
    <nav class="navbar navbar-expand-lg w-100">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('domain.home') }}">TEMPLATE</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-0 me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('domain.home') }}">Home</a>
                    </li>
                </ul>
                <form class="d-flex me-0 ms-auto" action="{{ route('domain.search') }}" role="search">
                    <input class="form-control me-2" type="search" name="q" placeholder="Search" aria-label="Search" value="{{ request('q') }}">
                    <button class="btn btn-outline-primary" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
</header>
