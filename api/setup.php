<?php
require_once 'config.php';

enableCORS();

$host = $_ENV['DB_HOST'] ?? 'localhost';
$username = $_ENV['DB_USER'] ?? 'root';
$password = $_ENV['DB_PASS'] ?? '';
$database = $_ENV['DB_NAME'] ?? 'hotel_booking';

// Create connection without specifying database first
$conn = new mysqli($host, $username, $password);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Connection failed: ' . $conn->connect_error]);
    exit();
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $database";
if ($conn->query($sql) === TRUE) {
    echo json_encode(['message' => "Database '$database' created or already exists"]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Error creating database: ' . $conn->error]);
    exit();
}

// Select the database
$conn->select_db($database);

// Create users table
$createUsersTable = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($createUsersTable) === TRUE) {
    echo json_encode(['message' => 'Users table created successfully']);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Error creating users table: ' . $conn->error]);
    exit();
}

// Create bookings table
$createBookingsTable = "CREATE TABLE IF NOT EXISTS bookings (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) UNSIGNED NOT NULL,
    room_type VARCHAR(50) NOT NULL,
    check_in DATE NOT NULL,
    check_out DATE NOT NULL,
    guests INT(2) NOT NULL,
    special_requests TEXT,
    total_price DECIMAL(10,2) NOT NULL,
    status VARCHAR(20) DEFAULT 'confirmed',
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)";

if ($conn->query($createBookingsTable) === TRUE) {
    echo json_encode(['success' => true, 'message' => 'Database setup completed successfully!']);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Error creating bookings table: ' . $conn->error]);
}

$conn->close();
?>
