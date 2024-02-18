<!doctype html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}" defer></script>
    @stack('styles')
<body>
    @php
        $genres = \App\Models\Genre::all();
    @endphp
        <div class="d-flex flex-column min-vh-100">
        <header>
            @include('includes.header', ['genres' => $genres])
        </header>
        <main>
            <div class="container-fluid">
                @yield('main')
            </div>
        </main>
        <footer>
            @include('includes.footer')
        </footer>
    </div>
    @stack('js')
</body>
</html>
