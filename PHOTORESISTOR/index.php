<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🌾 SmartFarm IoT • Sensors</title>
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

        .status-dot {
            display: inline-block;
            width: 14px;
            height: 14px;
            background: #00c853;
            border-radius: 50%;
            box-shadow: 0 0 0 5px rgba(0, 200, 83, 0.25);
            animation: pulse 2s infinite;
        }

        .status-dot.inactive {
            background: #f87171;
            box-shadow: 0 0 0 5px rgba(248, 113, 113, 0.25);
            animation: none;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(0, 200, 83, 0.5); }
            70% { box-shadow: 0 0 0 14px rgba(0, 200, 83, 0); }
            100% { box-shadow: 0 0 0 0 rgba(0, 200, 83, 0); }
        }

        .sensor-card {
            border-radius: 18px;
            padding: 20px;
            margin-bottom: 15px;
            background: white;
            border-left: 5px solid #00c853;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .sensor-card:hover {
            box-shadow: 0 8px 25px rgba(0, 200, 83, 0.15);
            transform: translateX(5px);
        }

        .sensor-card.inactive {
            border-left-color: #f87171;
            opacity: 0.85;
        }

        .sensor-id {
            font-weight: 700;
            color: #00c853;
            font-size: 1.2rem;
        }

        .sensor-location {
            color: #666;
            font-weight: 500;
        }

        .status-badge {
            border-radius: 20px;
            padding: 6px 14px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .status-active {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-inactive {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .header-section {
            background: linear-gradient(180deg, #e8f7f0 0%, #f0fdf4 100%);
            padding: 40px 20px;
            border-radius: 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0, 200, 83, 0.08);
        }

        .header-section h1 {
            color: #1e7e5f;
            font-size: 2.2rem;
            margin-bottom: 10px;
        }

        .header-section p {
            color: #4a9b7f;
            font-size: 1.05rem;
            margin: 0;
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

        .filters {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .filter-btn {
            border-radius: 20px;
            padding: 8px 16px;
            border: 2px solid #e5e7eb;
            background: white;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            color: #666;
        }

        .filter-btn.active {
            border-color: #00c853;
            background-color: #dcfce7;
            color: #166534;
        }

        .filter-btn:hover {
            border-color: #00c853;
        }

        .sensor-count {
            font-weight: 700;
            color: #00c853;
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
                        <a class="nav-link active" href="index.php">
                            <i class="fas fa-sensors me-1"></i> Sensors
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">
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
        </div>
    </nav>

    <div class="container py-5">
        <div class="header-section">
            <h1 class="text-center">
                <i class="fas fa-satellite me-2"></i>Sensor Inventory
            </h1>
            <p class="text-center">Monitor all connected IoT sensors and their connection status</p>
        </div>

        <!-- FILTERS -->
        <div class="bubble p-4 mb-4">
            <h6 class="mb-3 fw-bold"><i class="fas fa-filter me-2"></i>Filter Sensors</h6>
            <div class="filters">
                <button class="filter-btn active" onclick="filterSensors('all')">
                    <i class="fas fa-list me-1"></i> All
                </button>
                <button class="filter-btn" onclick="filterSensors('active')">
                    <span class="status-dot me-1" style="display: inline-block; margin-bottom: 2px;"></span> Active
                </button>
                <button class="filter-btn" onclick="filterSensors('inactive')">
                    <span class="status-dot inactive me-1" style="display: inline-block; margin-bottom: 2px;"></span> Inactive
                </button>
            </div>
        </div>

        <!-- SENSOR LIST -->
        <div class="bubble p-4">
            <div class="mb-4">
                <h5 class="mb-3"><i class="fas fa-microchip me-2"></i>Connected Sensors</h5>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted">
                        <span class="sensor-count" id="active-count">0</span> Active • 
                        <span class="sensor-count" id="inactive-count">0</span> Inactive
                    </span>
                    <button onclick="refreshSensors()" class="btn btn-success btn-sm rounded-pill px-4">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                </div>
            </div>

            <div id="sensors-container">
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-spinner fa-spin me-2"></i> Loading sensors...
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center py-5 text-muted small">
        SmartFarm IoT System • Last updated: <span id="last-update"></span>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let allSensors = [];
        let currentFilter = 'all';

        async function loadSensors() {
            try {
                const response = await fetch('get_latest_data.php', { cache: 'no-cache' });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                const data = await response.json();

                if (data.error) {
                    throw new Error(data.error + (data.details ? ': ' + data.details : ''));
                }

                // Extract unique sensors from summary
                if (data.summary && data.summary.length > 0) {
                    allSensors = data.summary.map(sensor => ({
                        ...sensor,
                        status: sensor.connection_status || 'active'
                    }));
                } else {
                    allSensors = [];
                }

                updateSensorDisplay();
                updateCounts();
                document.getElementById('last-update').textContent = new Date().toLocaleTimeString();

            } catch (err) {
                console.error("Sensor load error:", err);
                document.getElementById('sensors-container').innerHTML = `
                    <div class="alert alert-danger text-center py-4">
                        ❌ Failed to load sensors.<br>
                        <strong>Error:</strong> ${err.message}<br>
                        <small>Please check that <strong>get_latest_data.php</strong> is in the same folder.</small>
                    </div>`;
            }
        }

        function updateSensorDisplay() {
            const container = document.getElementById('sensors-container');
            
            let filtered = allSensors;
            if (currentFilter === 'active') {
                filtered = allSensors.filter(s => s.status === 'active');
            } else if (currentFilter === 'inactive') {
                filtered = allSensors.filter(s => s.status === 'inactive');
            }

            if (filtered.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-inbox me-2"></i> No sensors found
                    </div>`;
                return;
            }

            let html = filtered.map(sensor => `
                <a href="sensor_detail.php?sensor_id=${encodeURIComponent(sensor.sensor_id)}" style="text-decoration: none; color: inherit;">
                    <div class="sensor-card ${sensor.status === 'inactive' ? 'inactive' : ''}" style="cursor: pointer;">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="sensor-id">${sensor.sensor_id}</div>
                                <div class="sensor-location">
                                    <i class="fas fa-map-marker-alt me-1"></i>${sensor.location}
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <div class="d-flex align-items-center justify-content-end gap-2 mb-2">
                                    <span class="status-dot ${sensor.status === 'inactive' ? 'inactive' : ''}"></span>
                                    <span class="status-badge ${sensor.status === 'active' ? 'status-active' : 'status-inactive'}">
                                        ${sensor.status === 'active' ? '🟢 ACTIVE' : '🔴 INACTIVE'}
                                    </span>
                                </div>
                                <small class="text-muted d-block">Last reading: ${sensor.reading_time || 'N/A'}</small>
                            </div>
                        </div>
                        <div class="row mt-3 text-center">
                            <div class="col-4">
                                <small class="text-muted">Temperature</small><br>
                                <strong style="color: #00c853; font-size: 1.2rem;">${sensor.temperature}°C</strong>
                            </div>
                            <div class="col-4">
                                <small class="text-muted">Humidity</small><br>
                                <strong style="color: #00c853; font-size: 1.2rem;">${sensor.humidity}%</strong>
                            </div>
                            <div class="col-4">
                                <small class="text-muted">Light Level</small><br>
                                <strong style="color: #00c853; font-size: 1.2rem;">${sensor.light_level}</strong>
                            </div>
                        </div>
                    </div>
                </a>
            `).join('');

            container.innerHTML = html;
        }

        function updateCounts() {
            const activeCount = allSensors.filter(s => s.status === 'active').length;
            const inactiveCount = allSensors.filter(s => s.status === 'inactive').length;
            
            document.getElementById('active-count').textContent = activeCount;
            document.getElementById('inactive-count').textContent = inactiveCount;
        }

        function filterSensors(filter) {
            currentFilter = filter;
            
            // Update button states
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.closest('.filter-btn').classList.add('active');
            
            updateSensorDisplay();
        }

        function refreshSensors() {
            loadSensors();
        }

        function viewSensorDetails(sensorId) {
            window.location.href = `sensor-detail.php?id=${encodeURIComponent(sensorId)}`;
        }

        // Initialize
        window.onload = () => {
            loadSensors();
            setInterval(loadSensors, 30000);   // Auto-refresh every 30 seconds
        };
    </script>
</body>
</html>