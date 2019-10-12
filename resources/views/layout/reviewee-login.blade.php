<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Kode - @yield('title')</title>
    <link rel="stylesheet" href="{{ secure_url('/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ secure_url('/assets/fonts/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ secure_url('/assets/css/styles.min.css') }}">
</head>

<body>
    @yield('content')
    <script src="{{ secure_url('/assets/js/jquery.min.js') }}"></script>
    <script src="{{ secure_url('/assets/bootstrap/js/bootstrap.min.js') }}"></script>
</body>

</html>