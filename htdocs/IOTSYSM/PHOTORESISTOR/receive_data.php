<?php

header('Content-Type: application/json; charset=utf-8');

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "smartfarm";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => "Connection failed",
        "details" => $conn->connect_error,
        "timestamp" => date('Y-m-d H:i:s')
    ]);
    exit;
}

$sensor_id    = trim($_POST['sensor_id'] ?? '');
$location     = trim($_POST['location'] ?? '');
$temperature  = floatval($_POST['temperature'] ?? 0);
$humidity     = floatval($_POST['humidity'] ?? 0);
$light_level  = intval($_POST['light_level'] ?? 0);

if (empty($sensor_id) || empty($location)) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "error" => "Validation failed",
        "message" => "sensor_id and location are required",
        "received" => [
            "sensor_id" => $sensor_id,
            "location" => $location
        ],
        "timestamp" => date('Y-m-d H:i:s')
    ]);
    exit;
}

if ($temperature < -50 || $temperature > 60) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "error" => "Validation failed",
        "message" => "Temperature out of range (-50 to 60°C)",
        "received" => $temperature,
        "timestamp" => date('Y-m-d H:i:s')
    ]);
    exit;
}

if ($humidity < 0 || $humidity > 100) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "error" => "Validation failed",
        "message" => "Humidity out of range (0-100%)",
        "received" => $humidity,
        "timestamp" => date('Y-m-d H:i:s')
    ]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO sensor_readings 
    (sensor_id, location, temperature, humidity, light_level) 
    VALUES (?, ?, ?, ?, ?)");

if (!$stmt) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => "Database prepare failed",
        "details" => $conn->error,
        "timestamp" => date('Y-m-d H:i:s')
    ]);
    exit;
}

$stmt->bind_param("ssddi", $sensor_id, $location, $temperature, $humidity, $light_level);

if ($stmt->execute()) {
    http_response_code(201);
    echo json_encode([
        "success" => true,
        "message" => "Data saved successfully",
        "data" => [
            "sensor_id" => $sensor_id,
            "location" => $location,
            "temperature" => $temperature,
            "humidity" => $humidity,
            "light_level" => $light_level
        ],
        "timestamp" => date('Y-m-d H:i:s')
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => "Execute failed",
        "details" => $stmt->error,
        "timestamp" => date('Y-m-d H:i:s')
    ]);
}

$stmt->close();
$conn->close();
?>