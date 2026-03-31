<?php

if (ob_get_level() > 0) ob_clean();

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-cache, no-store, must-revalidate');

error_reporting(E_ALL);
ini_set('display_errors', '0');

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "smartfarm";

$conn = @new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => "Database connection failed",
        "details" => $conn->connect_error,
        "host" => $servername,
        "database" => $dbname,
        "timestamp" => date('Y-m-d H:i:s')
    ]);
    exit;
}

$conn->set_charset("utf8mb4");

$summaryQuery = "
    SELECT sensor_id, location, temperature, humidity, light_level, 
           DATE_FORMAT(reading_time, '%b %d %H:%i') AS reading_time
    FROM (
        SELECT *, ROW_NUMBER() OVER (PARTITION BY sensor_id ORDER BY reading_time DESC) as rn
        FROM sensor_readings
        WHERE reading_time >= NOW() - INTERVAL 24 HOUR
    ) t
    WHERE rn = 1
    ORDER BY location
";

$summary = [];
$summaryResult = $conn->query($summaryQuery);

if ($summaryResult) {
    while ($row = $summaryResult->fetch_assoc()) {
        $summary[] = $row;
    }
} else {
    $error_msg = $conn->error ?: "Unknown error";
    error_log("Summary query failed: " . $error_msg);
}

$allQuery = "
    SELECT sensor_id, location, temperature, humidity, light_level,
           DATE_FORMAT(reading_time, '%b %d %H:%i:%s') AS reading_time
    FROM sensor_readings 
    WHERE reading_time >= NOW() - INTERVAL 24 HOUR
    ORDER BY reading_time DESC
    LIMIT 50
";

$all_readings = [];
$allResult = $conn->query($allQuery);

if ($allResult) {
    while ($row = $allResult->fetch_assoc()) {
        $all_readings[] = $row;
    }
} else {
    $error_msg = $conn->error ?: "Unknown error";
    error_log("All readings query failed: " . $error_msg);
}

$conn->close();

echo json_encode([
    "success"      => true,
    "summary"      => $summary,
    "all_readings" => $all_readings,
    "total_records" => count($all_readings),
    "timestamp"    => date('Y-m-d H:i:s'),
    "last_updated" => !empty($all_readings) ? end($all_readings)['reading_time'] : null
]);
?>