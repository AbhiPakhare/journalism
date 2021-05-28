<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui/dist/css/coreui.min.css">

    <!-- Styles -->
    <style>
        html, body {
            background-image: url('{{ asset('images/background.png') }}');
            background-size: cover;
            background-position: top;
            min-height: 100vh;
            font-weight: 400;
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

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
            color: white;
        }
        .main {
            /* The image used */
            background-image: url('{{ asset('images/background-half.png') }}');

            /* Center and scale the image nicely */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        .auth-header {
            height: 100px;
            background-color: #316989;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            box-shadow: rgb(14 30 37 / 12%) 0px 2px 4px 0px, rgb(14 30 37 / 32%) 0px 2px 16px 0px;
            border: none !important;
        }
        .card-body {
            padding: 0 !important;
        }
        .card-content {
            padding: 1.5rem !important;
        }
    </style>
</head>
<body>
<div class="main">
    <div class="content">
        <div class="container-fluid flex-center full-height">
            @yield('content')
        </div>
    </div>
</div>
</body>
</html>


