<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hydration Buddy - Welcome</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .loading-container {
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }

        .welcome-text {
            font-size: 3.5rem;
            font-weight: bold;
            color: white;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);
            animation: slideIn 1s ease-out;
        }

        .water-drop {
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50% 50% 50% 0;
            transform: rotate(-45deg);
            margin: 40px auto;
            animation: bounce 1.5s infinite;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes bounce {
            0%, 100% {
                transform: rotate(-45deg) translateY(0);
            }
            50% {
                transform: rotate(-45deg) translateY(-20px);
            }
        }

        .loading-dots {
            color: white;
            font-size: 2rem;
            margin-top: 20px;
        }

        .loading-dots span {
            animation: blink 1.4s infinite both;
        }

        .loading-dots span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .loading-dots span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes blink {
            0%, 80%, 100% {
                opacity: 0;
            }
            40% {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <div class="loading-container">
        <div class="water-drop"></div>
        <h1 class="welcome-text">Hi welcome SEN</h1>
        <div class="loading-dots">
            <span>.</span><span>.</span><span>.</span>
        </div>
    </div>

    <script>
        // Redirect to dashboard after 3 seconds
        setTimeout(function() {
            window.location.href = "{{ route('dashboard') }}";
        }, 3000);
    </script>
</body>
</html>
