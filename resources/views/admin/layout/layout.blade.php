<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" rel="stylesheet" />
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <title>Car Rental Dashboard</title>
</head>

<body>
    <div class="wrapper">
        @include('admin.layout.aside')
        <div class="main">
            @include('admin.layout.nav')
            <main class="content px-3 py-4">
                @yield('content')
            </main>
        </div>
    </div>
    <x-session />
    <script src="https://kit.fontawesome.com/19d660dcf4.js" crossorigin="anonymous"></script>
    <script src="{{ mix('js/app.js') }}"></script>
    @stack('scripts')
</body>

</html>
