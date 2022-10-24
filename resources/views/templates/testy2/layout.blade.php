<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @hasSection('title')
            <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>
        @else
            <title>{{ config('app.name', 'Laravel') }}</title>
        @endif

        <meta content="@yield('description')" name="description"/>

        @hasSection('no_index')
            <meta name="robots" content="noindex,nofollow">
        @endif

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>
    <body>
        @yield('content')
    </body>
</html>
