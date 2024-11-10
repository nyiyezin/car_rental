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
    <script src="{{ mix('js/app.js') }}"></script>
    @stack('scripts')
</body>

</html>
