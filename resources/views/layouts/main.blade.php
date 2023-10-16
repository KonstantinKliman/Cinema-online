<!doctype html>
<html lang="en" class="h-100" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}" defer></script>
<body class="d-flex flex-column h-100">
<header>
        @include('components.header')
</header>
<main class="h-100">
    <div class="container-fluid h-100">
        @yield('main')
    </div>
</main>
<footer class="footer mt-auto py-3 bg-body-tertiary text-center">
    <div class="container-fluid">
        @include('components.footer')
    </div>
</footer>
</body>
</html>
