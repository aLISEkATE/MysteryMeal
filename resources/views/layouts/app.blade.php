<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MysteryMeal') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>

<body class="retro-body">

    <div class="app-wrapper">
        <!-- Navigation Menu -->
        <x-navigation-menu />

        @isset($header)
            <header class="page-header">
                <div class="header-inner">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main class="main-content">
            {{ $slot }}
        </main>

        <!-- Footer with Back Button -->
        <footer class="page-footer">
            <div class="footer-container">
                <button onclick="window.history.back()" class="back-btn">
                    ← Back
                </button>
                <p class="footer-text">© {{ date('Y') }} MysteryMeal - Delicious Recipes</p>
            </div>
        </footer>
    </div>

    <style>
        .page-footer {
            background: white;
            border-top: 1px solid #ffe3ec;
            padding: 20px 24px;
            margin-top: 40px;
        }
        
        .footer-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }
        
        .back-btn {
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            padding: 10px 20px;
            border-radius: 9999px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .back-btn:hover {
            background: #ff8fb1;
            color: white;
            border-color: #ff8fb1;
        }
        
        .footer-text {
            color: #9ca3af;
            font-size: 0.85rem;
        }
        
        /* Ensure main content takes available space */
        .app-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .main-content {
            flex: 1;
        }
    </style>
</body>
</html>