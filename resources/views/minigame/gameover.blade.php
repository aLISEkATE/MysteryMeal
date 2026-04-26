<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GAME OVER</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #fff8fb 0%, #f0e8ff 50%, #fff8fb 100%);
            font-family: 'Courier New', monospace;
            color: #6b6b8f;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
        }
        
        /* Pastel scanlines effect */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: repeating-linear-gradient(
                0deg,
                transparent,
                transparent 2px,
                rgba(167, 216, 255, 0.05) 2px,
                rgba(167, 216, 255, 0.05) 4px
            );
            pointer-events: none;
            z-index: 1;
        }
        
        h1 {
            font-size: 4rem;
            color: #ff8fb1;
            text-shadow: 
                0 2px 4px rgba(255, 139, 177, 0.2);
            margin-bottom: 2rem;
            animation: flicker 2s infinite alternate;
            position: relative;
            z-index: 2;
        }
        
        @keyframes flicker {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.95; }
        }
        
        p {
            font-size: 1.5rem;
            color: #6aa9ff;
            margin: 1rem 0;
            text-shadow: 0 2px 4px rgba(106, 169, 255, 0.1);
            position: relative;
            z-index: 2;
        }
        
        div {
            font-size: 1.2rem;
            color: #ff8fb1;
            margin: 1rem 0;
            text-shadow: 0 2px 4px rgba(255, 139, 177, 0.1);
            position: relative;
            z-index: 2;
        }
        
        a {
            margin-top: 2rem;
            padding: 15px 30px;
            background: #ffb3c7;
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            border: 2px solid #ff8fb1;
            font-size: 1.2rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            box-shadow: 
                0 4px 12px rgba(255, 139, 177, 0.2);
            transition: all 0.3s ease;
            position: relative;
            z-index: 2;
        }
        
        a:hover {
            background: #ff8fb1;
            box-shadow: 
                0 6px 16px rgba(255, 139, 177, 0.3);
            transform: translateY(-2px);
        }
        
        /* Pastel border effect */
        .retro-border {
            border: 3px solid #a7d8ff;
            padding: 40px;
            background: rgba(255, 255, 255, 0.7);
            box-shadow: 
                0 8px 24px rgba(167, 216, 255, 0.15);
            border-radius: 12px;
            position: relative;
            z-index: 2;
        }
    </style>
    @vite('resources/js/minigame.js')
</head>
<body>
    <div class="retro-border">
        <h1>GAME OVER</h1>

        <p>Your score: {{ request('score', 'Not recorded') }}</p>
        @php
            $time = request('time', 0);
            $minutes = floor($time / 60);
            $seconds = $time % 60;
            $timeFormatted = sprintf('%02d:%02d', $minutes, $seconds);
        @endphp
        <p>Your time: {{ $timeFormatted }}</p>
        <p>Your all-time high score: {{ $highScore }}</p>
        @php
            $longestMinutes = floor($longestTime / 60);
            $longestSeconds = $longestTime % 60;
            $longestTimeFormatted = sprintf('%02d:%02d', $longestMinutes, $longestSeconds);
        @endphp
        <p>Your longest time: {{ $longestTimeFormatted }}</p>
        <div>{{ Auth::user()->name }}</div>
        <a href="/minigame">Try Again</a>
    </div>
</body>
</html>
