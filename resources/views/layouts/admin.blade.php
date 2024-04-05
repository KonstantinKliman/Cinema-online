<!doctype html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}" defer></script>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @stack('styles')
<body class="d-flex flex-row min-vh-100 w-100">
    <aside class="d-flex flex-grow-1">
        @component('components.admin-sidebar')
        @endcomponent
    </aside>
    <main class="vw-100 d-flex flex-column">
        <div class="container-fluid flex-grow-1">
            @yield('main')
        </div>
        <footer>
            @include('includes.footer')
        </footer>
    </main>
    @stack('js')
</body>
</html>
