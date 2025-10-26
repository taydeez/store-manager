<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .email-wrapper {
            max-width: 600px;
            margin: 30px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(90deg, #0d6efd, #6610f2);
            color: #fff;
            text-align: center;
            padding: 30px 15px 20px;
        }

        .header-logo {
            display: inline-block;
            margin-bottom: 10px;
        }

        .header-logo img {
            max-width: 120px;
            height: auto;
            border-radius: 6px;
            background: #fff;
            padding: 5px;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
        }

        .header p {
            margin: 5px 0 0;
            opacity: 0.9;
        }

        .content {
            padding: 30px;
        }

        .footer {
            background-color: #f1f5f9;
            text-align: center;
            color: #777;
            font-size: 14px;
            padding: 20px;
        }

        a.btn {
            display: inline-block;
            background-color: #0d6efd;
            color: #fff !important;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 15px;
        }
    </style>
</head>
<body>
<div class="email-wrapper">
    {{-- Header --}}
    <div class="header">
        <div class="header-logo">
            @php
                $logoUrl = config('app.logo_url') ?? asset('images/logo.png');
            @endphp

            @if(file_exists(public_path('images/logo.png')))
                <img src="{{ $logoUrl }}" alt="{{ config('app.name') }} Logo">
            @else
                <h1>{{ config('app.name') }}</h1>
            @endif
        </div>

        <p>@yield('subtitle', 'Notification from ' . config('app.name'))</p>
    </div>

    {{-- Main content --}}
    <div class="content">
        @yield('content')
    </div>

    {{-- Footer --}}
    <div class="footer">
        <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        <p>
            Need help?
            <a href="mailto:support@{{ parse_url(config('app.url'), PHP_URL_HOST) }}">Contact Support</a>
        </p>
    </div>
</div>
</body>
</html>
