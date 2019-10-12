<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo env('APP_NAME', 'Kode'); ?></title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="{{ secure_url('/assets/fonts/font-awesome.min.css') }}" rel="stylesheet">

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #060606;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links>a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
        <div class="top-right links">
            @auth
            <a href="{{ secure_url('/home') }}">Home</a>
            @else
            <a href="{{ route('login') }}">Login</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}">Register</a>
            @endif
            @endauth
        </div>
        @endif

        <div class="content">
            <div class="title m-b-md">
                <?php echo env('APP_NAME', 'Kode'); ?>
            </div>

            <div class="links">
                <a href="{{ secure_url('/login') }}">Login</a>
                <a href="https://github.com/konnector-dev/kuotes/tree/flutter-dart-app" target="_blank">Kuotes (Flutter)</a>
                <a href="https://github.com/konnector-dev/kloudify/tree/wooks" target="_blank">Wooks(Laravel)</a>
                <a href="https://github.com/jdecode" target="_blank"><i class="fa fa-github"></i>/jdecode</a>
                <a href="https://twitter.com/jdecode" target="_blank"><i class="fa fa-twitter"></i>/jdecode</a>
                <br />
                <a href="" onclick="return false;" style="cursor: auto;">&copy; <?php echo date('Y'); ?></a>
            </div>
        </div>
    </div>
</body>

</html>