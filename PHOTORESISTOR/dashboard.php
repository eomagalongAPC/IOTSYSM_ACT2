<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🌾 SmartFarm IoT • Bubble Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
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

        .data-value {
            font-size: 3.2rem;
            font-weight: 800;
            background: linear-gradient(90deg, #00c853, #4ade80);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
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

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }

        .table {
            background: white;
            border-radius: 18px;
            overflow: hidden;
        }
        
        .table thead {
            background: #f0fdf4;
            color: #166534;
        }

        .night-row {
            background-color: #fefce8 !important;
        }

        .field-bubble {
            background: white;
            border: 3px solid #86efac;
            border-radius: 32px;
            transition: all 0.4s ease;
        }
        
        .field-bubble:hover {
            border-color: #00c853;
            transform: scale(1.04);
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

        .dashboard-header:hover h1 {
            animation: float 2s ease-in-out infinite;
        }

        .dashboard-header:hover p {
            animation: float 2.5s ease-in-out infinite;
        }

        .dashboard-header h1 {
            color: #1e7e5f;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .dashboard-header p {
            color: #4a9b7f;
            font-size: 1.1rem;
            margin: 0;
        }

        h1, h5 {
            font-weight: 700;
            color: #166534;
        }

        .alert-info {
            background-color: #d4f0ed !important;
            border-color: #a8e6e0 !important;
            color: #1e7e5f !important;
        }

        .alert-info strong {
            color: #0f5f4f;
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
                            <i class="fas fa-sensors me-1"></i> Sensors
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php">
                            <i class="fas fa-home me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="analytics.php">
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
                <button onclick="refreshDashboard()" class="btn btn-success btn-sm rounded-pill px-4">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="dashboard-header">
            <h1 class="text-center">
                <i class="fas fa-leaf me-2"></i>BESANA • JONOTA • MAGALONG • OROCEO •VENTURA
            </h1>
        </div>

        <!-- SUMMARY BUBBLES -->
        <div class="row g-4 mb-5" id="summary-cards"></div>

        <!-- SENSOR ANALYTICS LINK -->
        <div class="bubble p-4 mb-5 text-center" style="background: linear-gradient(135deg, rgba(0, 200, 83, 0.15) 0%, rgba(33, 150, 243, 0.15) 100%);">
            <h5 class="mb-3"><i class="fas fa-chart-analytics me-2"></i> Advanced Analytics Available</h5>
            <p class="text-muted mb-4">View detailed charts, trends, and comprehensive analysis of your sensor data</p>
            <a href="analytics.php" class="btn btn-success btn-lg rounded-pill">
                <i class="fas fa-chart-line me-2"></i> Go to Analytics Dashboard
            </a>
        </div>

        <!-- LIVE READINGS TABLE -->
        <div class="bubble p-4 mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0"><i class="fas fa-list me-2"></i> Recent Sensor Readings (Last 24h)</h5>
                <span class="badge bg-success fs-6 px-3 py-2" id="total-records">0 records</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="readings-table">
                    <thead>
                        <tr>
                            <th>Sensor ID</th>
                            <th>Location</th>
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

        <!-- FIELD BUBBLES -->
        <div class="bubble p-4">
            <h5 class="mb-4"><i class="fas fa-map-marked-alt me-2"></i> Farm Fields Overview</h5>
            <div class="row g-4" id="field-map"></div>
        </div>
    </div>

    <footer class="text-center py-5 text-muted small">
        SmartFarm IoT System • 
        Last updated: <span id="last-update"></span>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateClock() {
            const now = new Date();
            document.getElementById('current-time').textContent = 
                now.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', second: '2-digit' });
        }

        async function loadDashboard() {
            const summaryContainer = document.getElementById('summary-cards');
            const tableBody = document.getElementById('table-body');
            const fieldMap = document.getElementById('field-map');

            try {
                const response = await fetch('get_latest_data.php', { cache: 'no-cache' });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                const data = await response.json();

                // Check for errors in response
                if (data.error) {
                    throw new Error(data.error + (data.details ? ': ' + data.details : ''));
                }

                // Summary Bubbles
                let summaryHTML = '';
                if (data.summary && data.summary.length > 0) {
                    summaryHTML = data.summary.map(sensor => `
                        <div class="col-lg-4 col-md-6">
                            <div class="bubble text-center p-4 h-100">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="text-success fw-bold mb-0">${sensor.sensor_id}</h6>
                                    <span class="badge bg-success rounded-pill">${sensor.location}</span>
                                </div>
                                <div class="data-value my-2">${sensor.temperature}°C</div>
                                <small class="text-muted">Temperature</small>
                                
                                <div class="data-value my-3">${sensor.humidity}%</div>
                                <small class="text-muted">Humidity</small>
                                
                                <div class="mt-4 pt-3 border-top d-flex justify-content-center gap-2 align-items-center">
                                    <span class="fs-5">☀️ <strong>${sensor.light_level}</strong></span>
                                    <span class="badge ${sensor.light_level > 400 ? 'bg-success' : 'bg-warning'}">
                                        ${sensor.light_level > 400 ? 'DAYTIME' : 'NIGHT'}
                                    </span>
                                </div>
                                <small class="text-muted d-block mt-3">${sensor.reading_time}</small>
                            </div>
                        </div>
                    `).join('');
                } else {
                    summaryHTML = `<div class="col-12"><div class="alert alert-info text-center py-5">🌙 No daytime data received yet.<br>Edge computing is actively filtering nighttime readings.</div></div>`;
                }
                summaryContainer.innerHTML = summaryHTML;

                // Table
                let tableHTML = '';
                if (data.all_readings && data.all_readings.length > 0) {
                    data.all_readings.forEach(row => {
                        const isNight = row.light_level <= 400;
                        tableHTML += `
                            <tr class="${isNight ? 'night-row' : ''}">
                                <td><strong>${row.sensor_id}</strong></td>
                                <td>${row.location}</td>
                                <td>${row.reading_time}</td>
                                <td class="text-center fw-bold">${row.temperature}°C</td>
                                <td class="text-center fw-bold">${row.humidity}%</td>
                                <td class="text-center fw-bold">${row.light_level}</td>
                                <td class="text-center">
                                    <span class="badge ${row.light_level > 400 ? 'bg-success' : 'bg-secondary'} rounded-pill px-3">
                                        ${row.light_level > 400 ? '☀️ DAY' : '🌙 NIGHT'}
                                    </span>
                                </td>
                            </tr>`;
                    });
                } else {
                    tableHTML = `<tr><td colspan="7" class="text-center py-5 text-muted">Waiting for first daytime transmission from sensors...</td></tr>`;
                }
                tableBody.innerHTML = tableHTML;
                document.getElementById('total-records').textContent = `${data.all_readings ? data.all_readings.length : 0} records`;

                // Field Overview
                const grouped = {};
                if (data.summary) {
                    data.summary.forEach(s => {
                        if (!grouped[s.location]) grouped[s.location] = [];
                        grouped[s.location].push(s);
                    });
                }

                let mapHTML = '';
                if (Object.keys(grouped).length > 0) {
                    mapHTML = Object.keys(grouped).map(loc => `
                        <div class="col-md-6 col-lg-4">
                            <div class="field-bubble p-4 text-center">
                                <h6 class="text-success mb-3"><i class="fas fa-seedling me-1"></i>${loc}</h6>
                                <div class="d-flex justify-content-center gap-4 flex-wrap">
                                    ${grouped[loc].map(sensor => `
                                        <div class="text-center mx-2">
                                            <small class="text-muted">${sensor.sensor_id}</small><br>
                                            <span class="data-value fs-3">${sensor.temperature}°</span>
                                            <small class="d-block text-muted mt-1">Humidity ${sensor.humidity}%</small>
                                        </div>
                                    `).join('')}
                                </div>
                            </div>
                        </div>
                    `).join('');
                } else {
                    mapHTML = `<div class="col-12 text-center py-5 text-muted">No field data available yet</div>`;
                }
                fieldMap.innerHTML = mapHTML;

                // Last updated
                document.getElementById('last-update').textContent = new Date().toLocaleTimeString();

            } catch (err) {
                console.error("Dashboard load error:", err);
                summaryContainer.innerHTML = `
                    <div class="col-12">
                        <div class="alert alert-danger text-center py-4">
                            ❌ Failed to load data from server.<br>
                            <strong>Error:</strong> ${err.message}<br>
                            <small>Please check that <strong>get_latest_data.php</strong> is in the same folder and Apache is running.</small>
                        </div>
                    </div>`;
            }
        }

        function refreshDashboard() {
            loadDashboard();
        }

        // Initialize Dashboard
        window.onload = () => {
            updateClock();
            setInterval(updateClock, 1000);
            loadDashboard();
            setInterval(loadDashboard, 10000);   // Auto-refresh every 10 seconds
        };
    </script>
</body>
</html>
