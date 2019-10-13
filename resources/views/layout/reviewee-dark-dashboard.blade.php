<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Kode - @yield('title')</title>
    <link rel="stylesheet" href="{{  url('/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{  url('/assets/fonts/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{  url('/assets/fonts/font-awesome.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:400,500,700">

    <link rel="stylesheet" href="{{  url('/assets/fonts/fontawesome5-overrides.min.css?h=cfa788754642173dafbd830bd7969fdb') }}">
    <link rel="stylesheet" href="{{  url('/assets/css/Article-Clean.css?h=5d2455e1fa7653ce290cec1c4efa33f9') }}">
    <link rel="stylesheet" href="{{  url('/assets/css/dashboard-dark-sidebar.css?h=3612d7d9271bbe07ff4d2f09abddea71') }}">
    <link rel="stylesheet" href="{{  url('/assets/css/dark-styles.css') }}">

</head>

<body>
    @yield('content')
    <script src="{{  url('/assets/js/jquery.min.js') }}"></script>
    <script src="{{  url('/assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{  url('/assets/js/sidebar.js?h=5698962290ef9fcb7ad2ffc60db8773a') }}"></script>
</body>

</html>