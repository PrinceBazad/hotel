<?php
// Database configuration for Vercel deployment
function getDbConnection() {
    // Use environment variables for database connection
    $host = $_ENV['DB_HOST'] ?? 'localhost';
    $username = $_ENV['DB_USER'] ?? 'root';
    $password = $_ENV['DB_PASS'] ?? '';
    $database = $_ENV['DB_NAME'] ?? 'hotel_booking';
    
    $conn = new mysqli($host, $username, $password, $database);
    
    if ($conn->connect_error) {
        http_response_code(500);
        echo json_encode(['error' => 'Database connection failed']);
        exit();
    }
    
    return $conn;
}

// Enable CORS for frontend requests
function enableCORS() {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit();
    }
}

// Handle JSON input
function getJsonInput() {
    $input = file_get_contents('php://input');
    return json_decode($input, true);
}
?>
