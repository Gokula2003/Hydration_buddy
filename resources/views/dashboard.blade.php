<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Hydration Buddy - Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            color: white;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .dashboard-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
        }

        .today-section {
            text-align: center;
        }

        .glass-counter {
            font-size: 4rem;
            font-weight: bold;
            color: #667eea;
            margin: 20px 0;
        }

        .glass-counter span {
            font-size: 2rem;
            color: #999;
        }

        .ml-counter {
            font-size: 1.5rem;
            color: #666;
            margin-bottom: 20px;
        }

        .progress-bar-container {
            width: 100%;
            height: 30px;
            background: #f0f0f0;
            border-radius: 15px;
            overflow: hidden;
            margin: 20px 0;
            position: relative;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            transition: width 0.5s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .add-glass-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 20px 60px;
            font-size: 1.5rem;
            border-radius: 50px;
            cursor: pointer;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
            transition: all 0.3s ease;
            margin: 20px 0;
        }

        .add-glass-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
        }

        .add-glass-btn:active {
            transform: translateY(0);
        }

        .glasses-visual {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 20px 0;
            flex-wrap: wrap;
        }

        .glass-icon {
            width: 40px;
            height: 50px;
            background: #e0e0e0;
            border-radius: 5px 5px 10px 10px;
            position: relative;
            transition: all 0.3s ease;
        }

        .glass-icon.filled {
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
        }

        .history-section {
            margin-top: 20px;
        }

        .history-title {
            font-size: 1.3rem;
            color: #667eea;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .history-item {
            display: flex;
            justify-content: space-between;
            padding: 15px;
            background: #f8f8f8;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .history-date {
            font-weight: bold;
            color: #333;
        }

        .history-count {
            color: #667eea;
            font-weight: bold;
        }

        .goal-text {
            color: #666;
            font-size: 1.1rem;
            margin: 10px 0;
        }

        .status-message {
            padding: 15px;
            border-radius: 10px;
            margin: 15px 0;
            text-align: center;
            font-weight: bold;
            display: none;
        }

        .status-message.success {
            background: #d4edda;
            color: #155724;
            display: block;
            animation: fadeInOut 2s ease;
        }

        @keyframes fadeInOut {
            0%, 100% { opacity: 0; }
            10%, 90% { opacity: 1; }
        }

        .achievement {
            background: #fff3cd;
            border: 2px solid #ffc107;
            padding: 15px;
            border-radius: 10px;
            margin: 15px 0;
            text-align: center;
            font-weight: bold;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>💧 Hydration Buddy</h1>
            <p>Stay hydrated, stay healthy!</p>
        </div>

        <div class="dashboard-card">
            <div class="today-section">
                <h2 style="color: #667eea; margin-bottom: 20px;">Today's Progress</h2>
                
                <div class="glass-counter">
                    <span id="glasses-count">{{ $today->glasses_count ?? 0 }}</span>
                    <span>/ 8 glasses</span>
                </div>

                <div class="ml-counter">
                    <span id="ml-count">{{ ($today->glasses_count ?? 0) * 250 }}</span> ml / 2000 ml
                </div>

                <div class="progress-bar-container">
                    <div class="progress-bar" id="progress-bar" style="width: {{ min(($today->glasses_count ?? 0) / 8 * 100, 100) }}%">
                        <span id="progress-text">{{ round(min(($today->glasses_count ?? 0) / 8 * 100, 100)) }}%</span>
                    </div>
                </div>

                <div class="glasses-visual" id="glasses-visual">
                    @for ($i = 1; $i <= 8; $i++)
                        <div class="glass-icon {{ $i <= ($today->glasses_count ?? 0) ? 'filled' : '' }}"></div>
                    @endfor
                </div>

                <div class="status-message" id="status-message"></div>

                @if(($today->glasses_count ?? 0) >= 8)
                    <div class="achievement">
                        🎉 Congratulations! You've reached your daily goal! 🎉
                    </div>
                @endif

                <button class="add-glass-btn" onclick="addGlass()" id="add-glass-btn">
                    ➕ Add Glass
                </button>

                <p class="goal-text">Goal: 8 glasses (250ml each) per day</p>
            </div>
        </div>

        <div class="dashboard-card history-section">
            <h3 class="history-title">📊 History</h3>
            
            <div class="history-item">
                <div class="history-date">
                    Today ({{ $today->intake_date->format('M d, Y') }})
                </div>
                <div class="history-count">
                    {{ $today->glasses_count ?? 0 }} glasses ({{ ($today->glasses_count ?? 0) * 250 }}ml)
                </div>
            </div>

            @if($yesterday)
            <div class="history-item">
                <div class="history-date">
                    Yesterday ({{ $yesterday->intake_date->format('M d, Y') }})
                </div>
                <div class="history-count">
                    {{ $yesterday->glasses_count }} glasses ({{ $yesterday->glasses_count * 250 }}ml)
                </div>
            </div>
            @else
            <div class="history-item">
                <div class="history-date">Yesterday</div>
                <div class="history-count" style="color: #999;">No data</div>
            </div>
            @endif
        </div>
    </div>

    <script>
        // Set up CSRF token for AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        async function addGlass() {
            const btn = document.getElementById('add-glass-btn');
            btn.disabled = true;
            btn.textContent = 'Adding...';

            try {
                const response = await fetch('{{ route('api.add-glass') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                const data = await response.json();

                if (data.success) {
                    updateDashboard(data.glasses_count);
                    showStatusMessage('Glass added! Keep it up! 💧', 'success');
                }
            } catch (error) {
                console.error('Error:', error);
                showStatusMessage('Error adding glass. Please try again.', 'error');
            } finally {
                btn.disabled = false;
                btn.textContent = '➕ Add Glass';
            }
        }

        function updateDashboard(glassesCount) {
            // Update counter
            document.getElementById('glasses-count').textContent = glassesCount;
            document.getElementById('ml-count').textContent = glassesCount * 250;

            // Update progress bar
            const progress = Math.min((glassesCount / 8) * 100, 100);
            const progressBar = document.getElementById('progress-bar');
            progressBar.style.width = progress + '%';
            document.getElementById('progress-text').textContent = Math.round(progress) + '%';

            // Update visual glasses
            const glassIcons = document.querySelectorAll('.glass-icon');
            glassIcons.forEach((icon, index) => {
                if (index < glassesCount) {
                    icon.classList.add('filled');
                } else {
                    icon.classList.remove('filled');
                }
            });

            // Show achievement if goal reached
            if (glassesCount >= 8) {
                const achievement = document.createElement('div');
                achievement.className = 'achievement';
                achievement.innerHTML = '🎉 Congratulations! You\'ve reached your daily goal! 🎉';
                
                const existingAchievement = document.querySelector('.achievement');
                if (!existingAchievement) {
                    const todaySection = document.querySelector('.today-section');
                    const addBtn = document.getElementById('add-glass-btn');
                    todaySection.insertBefore(achievement, addBtn);
                }
            }

            // Refresh page to update history (optional)
            // This ensures the history section shows updated data
            setTimeout(() => {
                location.reload();
            }, 2000);
        }

        function showStatusMessage(message, type) {
            const statusMsg = document.getElementById('status-message');
            statusMsg.textContent = message;
            statusMsg.className = 'status-message ' + type;
            
            setTimeout(() => {
                statusMsg.style.display = 'none';
            }, 2000);
        }

        // Auto-refresh data every minute to check for midnight reset
        setInterval(async () => {
            try {
                const response = await fetch('{{ route('api.today') }}');
                const data = await response.json();
                
                // If date changed or count reset, reload page
                const currentCount = parseInt(document.getElementById('glasses-count').textContent);
                if (data.glasses_count < currentCount) {
                    location.reload();
                }
            } catch (error) {
                console.error('Error refreshing data:', error);
            }
        }, 60000); // Check every minute
    </script>
</body>
</html>
