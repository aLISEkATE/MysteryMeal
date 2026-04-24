<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MysteryMeal') }}</title>

    <!-- Retro Font -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>

<body class="retro-body">

    <div class="guest-wrapper">

        <div class="logo-box">
            <a href="/">
                <x-application-logo class="logo"/>
            </a>
        </div>

        <div class="guest-card">
            {{ $slot }}
        </div>

    </div>

</body>
</html>