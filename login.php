<?php
// Simple login page
require_once 'api/config.php';
enableCORS();

// Get environment variables for debugging
$db_host = $_ENV['DB_HOST'] ?? 'NOT SET';
$db_user = $_ENV['DB_USER'] ?? 'NOT SET';
$db_name = $_ENV['DB_NAME'] ?? 'NOT SET';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Luxury Hotel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 400px;
        }
        .login-container h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        .btn {
            width: 100%;
            padding: 12px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-bottom: 20px;
        }
        .btn:hover {
            background: #5a6fd8;
        }
        .links {
            text-align: center;
        }
        .links a {
            color: #667eea;
            text-decoration: none;
            margin: 0 10px;
        }
        .debug-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>🏨 Hotel Login</h1>
        
        <div class="debug-info">
            <strong>System Status:</strong><br>
            ✅ PHP is working<br>
            📊 DB Host: <?php echo htmlspecialchars($db_host); ?><br>
            👤 DB User: <?php echo htmlspecialchars($db_user); ?><br>
            🗄️ DB Name: <?php echo htmlspecialchars($db_name); ?>
        </div>

        <form action="api/auth.php" method="POST">
            <input type="hidden" name="action" value="login">
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn">Login</button>
        </form>
        
        <div class="links">
            <a href="/">← Back to Home</a> |
            <a href="register.php">Register</a> |
            <a href="test.php">Test Page</a>
        </div>
    </div>
</body>
</html>
