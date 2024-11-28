<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <title>Car Rental</title>
</head>

<body>
    @include('partials.home-navigation')
    <main class="shell">
        @yield('content')
    </main>
    <x-session />
    <script src="https://kit.fontawesome.com/19d660dcf4.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ mix('js/app.js') }}"></script>
    @stack('scripts')
</body>

</html>
