<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🌾 SmartFarm IoT • Analytics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <style>
        :root {
            --primary: #00c853;
        }
        
        body {
            background: linear-gradient(135deg, #f0fdf4 0%, #e0f2fe 100%);
            color: #1f2937;
            font-family: 'Segoe UI', system-ui, sans-serif;
            min-height: 100vh;
        }

        .bubble {
            background: white;
            border-radius: 28px;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.07);
            border: 2px solid rgba(0, 200, 83, 0.18);
            transition: all 0.4s ease;
        }
        
        .bubble:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0, 200, 83, 0.18);
        }

        .navbar {
            background: rgba(255, 255, 255, 0.97) !important;
            backdrop-filter: blur(15px);
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
        }

        .navbar-brand {
            font-weight: 800;
            color: #00c853 !important;
            letter-spacing: -1.5px;
            transition: all 0.4s ease;
            padding: 10px 15px;
            border-radius: 12px;
        }

        .navbar-brand:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 200, 83, 0.25);
            background: rgba(0, 200, 83, 0.08);
        }

        .status-dot {
            display: inline-block;
            width: 14px;
            height: 14px;
            background: #00c853;
            border-radius: 50%;
            box-shadow: 0 0 0 5px rgba(0, 200, 83, 0.25);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(0, 200, 83, 0.5); }
            70% { box-shadow: 0 0 0 14px rgba(0, 200, 83, 0); }
            100% { box-shadow: 0 0 0 0 rgba(0, 200, 83, 0); }
        }

        .dashboard-header {
            background: linear-gradient(180deg, #e8f7f0 0%, #f0fdf4 100%);
            padding: 40px 20px;
            border-radius: 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0, 200, 83, 0.08);
            transition: all 0.4s ease;
        }

        .dashboard-header:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0, 200, 83, 0.25);
        }

        .dashboard-header h1 {
            color: #1e7e5f;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        h1, h5 {
            font-weight: 700;
            color: #166534;
        }

        .chart-container {
            position: relative;
            height: 350px;
            margin-bottom: 20px;
        }

        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
            gap: 20px;
        }

        @media (max-width: 768px) {
            .charts-grid {
                grid-template-columns: 1fr;
            }
            
            .chart-container {
                height: 300px;
            }
        }

        .nav-link {
            color: #166534 !important;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: #00c853 !important;
        }

        .nav-link.active {
            background: rgba(0, 200, 83, 0.15) !important;
            color: #00c853 !important;
        }

        .stats-bubble {
            background: white;
            border-radius: 18px;
            padding: 20px;
            border: 2px solid rgba(0, 200, 83, 0.18);
            text-align: center;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 800;
            color: #00c853;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #666;
            font-size: 0.9rem;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand fs-3" href="index.php">
                <i class="fas fa-leaf me-2"></i>
                SMART AGRICULTURE
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto gap-2">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <i class="fas fa-home me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="analytics.php">
                            <i class="fas fa-chart-line me-1"></i> Analytics
                        </a>
                    </li>
                </ul>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center">
                    <span class="status-dot me-2"></span>
                    <span class="fw-bold text-success">Active</span>
                </div>
                <span id="current-time" class="text-muted small"></span>
                <button onclick="refreshCharts()" class="btn btn-success btn-sm rounded-pill px-4">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="dashboard-header">
            <h1 class="text-center">
                <i class="fas fa-chart-line me-2"></i>Sensor Analytics & Trends
            </h1>
            <p class="text-center text-muted mt-3">Real-time visualization of temperature, humidity, and light level data</p>
        </div>

        <!-- STATISTICS CARDS -->
        <div class="row g-3 mb-5" id="stats-cards"></div>

        <!-- SENSOR ANALYTICS CHARTS -->
        <div class="bubble p-4 mb-5">
            <h5 class="mb-4"><i class="fas fa-chart-line me-2"></i> Comprehensive Sensor Analytics</h5>
            <div class="charts-grid">
                <div>
                    <div class="chart-container">
                        <canvas id="tempChart"></canvas>
                    </div>
                    <p class="text-center text-muted small fw-bold">Temperature Trends (°C)</p>
                </div>
                <div>
                    <div class="chart-container">
                        <canvas id="humidityChart"></canvas>
                    </div>
                    <p class="text-center text-muted small fw-bold">Humidity Trends (%)</p>
                </div>
                <div>
                    <div class="chart-container">
                        <canvas id="lightChart"></canvas>
                    </div>
                    <p class="text-center text-muted small fw-bold">Light Level Trends</p>
                </div>
            </div>
        </div>

        <!-- COMBINED METRICS CHART -->
        <div class="bubble p-4 mb-5">
            <h5 class="mb-4"><i class="fas fa-chart-bar me-2"></i> Combined Sensor Comparison</h5>
            <div class="chart-container" style="height: 400px;">
                <canvas id="combinedChart"></canvas>
            </div>
        </div>

        <!-- DATA TABLE -->
        <div class="bubble p-4">
            <h5 class="mb-4"><i class="fas fa-table me-2"></i> Recent Readings</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="analytics-table">
                    <thead style="background: #f0fdf4;">
                        <tr>
                            <th>Timestamp</th>
                            <th class="text-center">Temp (°C)</th>
                            <th class="text-center">Humidity (%)</th>
                            <th class="text-center">Light Level</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody id="table-body"></tbody>
                </table>
            </div>
        </div>
    </div>

    <footer class="text-center py-5 text-muted small">
        SmartFarm IoT System • Analytics Dashboard • 
        Last updated: <span id="last-update"></span>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let tempChart, humidityChart, lightChart, combinedChart;
        let allReadings = [];

        function updateClock() {
            const now = new Date();
            document.getElementById('current-time').textContent = 
                now.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', second: '2-digit' });
        }

        async function loadAnalytics() {
            try {
                const response = await fetch('get_latest_data.php', { cache: 'no-cache' });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                const data = await response.json();

                if (data.error) {
                    throw new Error(data.error + (data.details ? ': ' + data.details : ''));
                }

                if (data.all_readings && data.all_readings.length > 0) {
                    allReadings = data.all_readings;
                    updateCharts(data.all_readings);
                    updateTable(data.all_readings);
                    updateStats(data.all_readings);
                }

                document.getElementById('last-update').textContent = new Date().toLocaleTimeString();

            } catch (err) {
                console.error("Analytics load error:", err);
                document.getElementById('stats-cards').innerHTML = `
                    <div class="col-12">
                        <div class="alert alert-danger text-center py-4">
                            ❌ Failed to load analytics data.<br>
                            <strong>Error:</strong> ${err.message}
                        </div>
                    </div>`;
            }
        }

        function updateStats(readings) {
            if (!readings || readings.length === 0) return;

            const temps = readings.map(r => parseFloat(r.temperature));
            const humidities = readings.map(r => parseFloat(r.humidity));
            const lights = readings.map(r => parseInt(r.light_level));

            const statsHTML = `
                <div class="col-md-3 col-sm-6">
                    <div class="stats-bubble">
                        <div class="stat-value">${Math.max(...temps).toFixed(1)}°</div>
                        <div class="stat-label">Max Temperature</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stats-bubble">
                        <div class="stat-value">${(temps.reduce((a, b) => a + b) / temps.length).toFixed(1)}°</div>
                        <div class="stat-label">Avg Temperature</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stats-bubble">
                        <div class="stat-value">${Math.max(...humidities).toFixed(0)}%</div>
                        <div class="stat-label">Max Humidity</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stats-bubble">
                        <div class="stat-value">${Math.max(...lights)}</div>
                        <div class="stat-label">Peak Light Level</div>
                    </div>
                </div>
            `;
            document.getElementById('stats-cards').innerHTML = statsHTML;
        }

        function updateTable(readings) {
            let tableHTML = '';
            readings.slice(-15).reverse().forEach(row => {
                const isNight = row.light_level <= 400;
                tableHTML += `
                    <tr>
                        <td><small>${row.reading_time}</small></td>
                        <td class="text-center fw-bold">${row.temperature}°C</td>
                        <td class="text-center fw-bold">${row.humidity}%</td>
                        <td class="text-center fw-bold">${row.light_level}</td>
                        <td class="text-center">
                            <span class="badge ${isNight ? 'bg-secondary' : 'bg-success'} rounded-pill px-3">
                                ${isNight ? '🌙 NIGHT' : '☀️ DAY'}
                            </span>
                        </td>
                    </tr>`;
            });
            document.getElementById('table-body').innerHTML = tableHTML;
        }

        function updateCharts(readings) {
            const labels = readings.slice(-12).map(r => r.reading_time).reverse();
            const tempData = readings.slice(-12).map(r => parseFloat(r.temperature)).reverse();
            const humidityData = readings.slice(-12).map(r => parseFloat(r.humidity)).reverse();
            const lightData = readings.slice(-12).map(r => parseInt(r.light_level)).reverse();

            // Temperature Chart
            const tempCtx = document.getElementById('tempChart').getContext('2d');
            if (tempChart) tempChart.destroy();
            tempChart = new Chart(tempCtx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Temperature (°C)',
                        data: tempData,
                        borderColor: '#00c853',
                        backgroundColor: 'rgba(0, 200, 83, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 5,
                        pointBackgroundColor: '#00c853',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                color: '#166534',
                                font: { weight: 'bold', size: 12 }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            ticks: { color: '#666' },
                            grid: { color: 'rgba(0,0,0,0.05)' }
                        },
                        x: {
                            ticks: { color: '#666' },
                            grid: { display: false }
                        }
                    }
                }
            });

            // Humidity Chart
            const humidityCtx = document.getElementById('humidityChart').getContext('2d');
            if (humidityChart) humidityChart.destroy();
            humidityChart = new Chart(humidityCtx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Humidity (%)',
                        data: humidityData,
                        borderColor: '#2196F3',
                        backgroundColor: 'rgba(33, 150, 243, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 5,
                        pointBackgroundColor: '#2196F3',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                color: '#166534',
                                font: { weight: 'bold', size: 12 }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            ticks: { color: '#666' },
                            grid: { color: 'rgba(0,0,0,0.05)' }
                        },
                        x: {
                            ticks: { color: '#666' },
                            grid: { display: false }
                        }
                    }
                }
            });

            // Light Level Chart
            const lightCtx = document.getElementById('lightChart').getContext('2d');
            if (lightChart) lightChart.destroy();
            lightChart = new Chart(lightCtx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Light Level',
                        data: lightData,
                        borderColor: '#FFC107',
                        backgroundColor: 'rgba(255, 193, 7, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 5,
                        pointBackgroundColor: '#FFC107',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                color: '#166534',
                                font: { weight: 'bold', size: 12 }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { color: '#666' },
                            grid: { color: 'rgba(0,0,0,0.05)' }
                        },
                        x: {
                            ticks: { color: '#666' },
                            grid: { display: false }
                        }
                    }
                }
            });

            // Combined Chart
            const combinedCtx = document.getElementById('combinedChart').getContext('2d');
            if (combinedChart) combinedChart.destroy();
            combinedChart = new Chart(combinedCtx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Temperature (°C)',
                            data: tempData,
                            backgroundColor: 'rgba(0, 200, 83, 0.7)',
                            borderColor: '#00c853',
                            borderWidth: 2,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Humidity (%)',
                            data: humidityData,
                            backgroundColor: 'rgba(33, 150, 243, 0.7)',
                            borderColor: '#2196F3',
                            borderWidth: 2,
                            yAxisID: 'y'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                color: '#166534',
                                font: { weight: 'bold', size: 12 }
                            }
                        }
                    },
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            beginAtZero: true,
                            ticks: { color: '#666' },
                            grid: { color: 'rgba(0,0,0,0.05)' }
                        },
                        x: {
                            ticks: { color: '#666' },
                            grid: { display: false }
                        }
                    }
                }
            });
        }

        function refreshCharts() {
            loadAnalytics();
        }

        // Initialize
        window.onload = () => {
            updateClock();
            setInterval(updateClock, 1000);
            loadAnalytics();
            setInterval(loadAnalytics, 10000);
        };
    </script>
</body>
</html>
