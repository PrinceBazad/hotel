<?php
// Simple database setup page
require_once 'api/config.php';
enableCORS();

echo "<h1>🗄️ Database Setup</h1>";

// Get environment variables
$host = $_ENV['DB_HOST'] ?? 'localhost';
$username = $_ENV['DB_USER'] ?? 'root';
$password = $_ENV['DB_PASS'] ?? '';
$database = $_ENV['DB_NAME'] ?? 'defaultdb';
$port = $_ENV['DB_PORT'] ?? 3306;

echo "<p>Connecting to: <strong>$host:$port</strong></p>";
echo "<p>Using database: <strong>$database</strong></p>";

try {
    // Create connection
    $conn = new mysqli($host, $username, $password, $database, $port);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    echo "<p style='color: green;'>✅ Connected to database successfully!</p>";
    
    // Create users table
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>✅ Users table created successfully</p>";
    } else {
        echo "<p style='color: red;'>❌ Error creating users table: " . htmlspecialchars($conn->error) . "</p>";
    }
    
    // Create bookings table
    $sql = "CREATE TABLE IF NOT EXISTS bookings (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id INT(6) UNSIGNED NOT NULL,
        room_type VARCHAR(50) NOT NULL,
        check_in DATE NOT NULL,
        check_out DATE NOT NULL,
        guests INT(2) NOT NULL,
        special_requests TEXT,
        total_price DECIMAL(10,2) NOT NULL,
        status VARCHAR(20) DEFAULT 'confirmed',
        booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>✅ Bookings table created successfully</p>";
    } else {
        echo "<p style='color: red;'>❌ Error creating bookings table: " . htmlspecialchars($conn->error) . "</p>";
    }
    
    echo "<hr>";
    echo "<h2>🎉 Database Setup Complete!</h2>";
    echo "<p>Your hotel website is now ready to use.</p>";
    
    $conn->close();
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<hr>";
echo "<p><a href='/'>← Back to Home</a> | <a href='test.php'>Test Page</a> | <a href='login.php'>Login</a></p>";
?>
