<?php

$servername = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>SmartFarm IoT - Database Setup</h2>";
echo "<p>Initializing database...</p>";

$sql = "CREATE DATABASE IF NOT EXISTS smartfarm";
if ($conn->query($sql) === TRUE) {
    echo "✓ Database 'smartfarm' created successfully<br>";
} else {
    echo "✗ Error creating database: " . $conn->error . "<br>";
}

$conn->close();
$conn = new mysqli($servername, $username, $password, "smartfarm");

if ($conn->connect_error) {
    die("Connection to new database failed: " . $conn->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS sensor_readings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sensor_id VARCHAR(50) NOT NULL,
    location VARCHAR(100) NOT NULL,
    temperature DECIMAL(5, 2),
    humidity DECIMAL(5, 2),
    light_level INT,
    is_daytime TINYINT DEFAULT 0,
    connection_status VARCHAR(20) DEFAULT 'active' COMMENT 'active or inactive based on IDE/WiFi connection',
    last_ping_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    reading_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_sensor (sensor_id),
    INDEX idx_location (location),
    INDEX idx_time (reading_time),
    INDEX idx_status (connection_status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if ($conn->query($sql) === TRUE) {
    echo "✓ Table 'sensor_readings' created successfully<br>";
} else {
    echo "✗ Error creating table: " . $conn->error . "<br>";
}

$sql = "CREATE OR REPLACE VIEW sensor_summary AS
SELECT 
    sensor_id,
    location,
    temperature,
    humidity,
    light_level,
    reading_time
FROM sensor_readings
WHERE reading_time >= DATE_SUB(NOW(), INTERVAL 24 HOUR)
ORDER BY reading_time DESC";

if ($conn->query($sql) === TRUE) {
    echo "✓ View 'sensor_summary' created successfully<br>";
} else {
    echo "✗ Error creating view: " . $conn->error . "<br>";
}

$conn->close();

echo "<br><hr>";
echo "<h3>✓ Database Setup Complete!</h3>";
echo "<p><strong>Database Name:</strong> smartfarm</p>";
echo "<p><strong>Table Name:</strong> sensor_readings</p>";
echo "<p><strong>Use the dashboard at:</strong> <a href='index.php'>Dashboard</a></p>";
?>
