<?php
// Simple test page
require_once 'api/config.php';
enableCORS();

echo "<h1>🧪 PHP Test Page</h1>";
echo "<p>✅ PHP is working!</p>";
echo "<h2>Environment Variables:</h2>";
echo "<p>DB_HOST: " . ($_ENV['DB_HOST'] ?? 'NOT SET') . "</p>";
echo "<p>DB_USER: " . ($_ENV['DB_USER'] ?? 'NOT SET') . "</p>";
echo "<p>DB_NAME: " . ($_ENV['DB_NAME'] ?? 'NOT SET') . "</p>";
echo "<p>DB_PORT: " . ($_ENV['DB_PORT'] ?? 'NOT SET') . "</p>";
echo "<p>Current time: " . date('Y-m-d H:i:s') . "</p>";

// Test basic database connection
try {
    $host = $_ENV['DB_HOST'] ?? 'localhost';
    $username = $_ENV['DB_USER'] ?? 'root';
    $password = $_ENV['DB_PASS'] ?? '';
    $database = $_ENV['DB_NAME'] ?? 'defaultdb';
    $port = $_ENV['DB_PORT'] ?? 3306;
    
    echo "<h2>Database Connection Test:</h2>";
    echo "<p>Attempting to connect to: $host:$port</p>";
    
    $conn = new mysqli($host, $username, $password, $database, $port);
    
    if ($conn->connect_error) {
        echo "<p style='color: red;'>❌ Connection failed: " . htmlspecialchars($conn->connect_error) . "</p>";
    } else {
        echo "<p style='color: green;'>✅ Database connected successfully!</p>";
        echo "<p>Server info: " . htmlspecialchars($conn->server_info) . "</p>";
        $conn->close();
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<hr>";
echo "<p><a href='/'>← Back to Home</a> | <a href='setup_database.php'>Setup Database</a></p>";
?>
