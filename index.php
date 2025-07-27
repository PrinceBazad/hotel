<?php
// Main router for the hotel website
$request = $_SERVER['REQUEST_URI'];
$path = parse_url($request, PHP_URL_PATH);

// Remove leading slash and clean path
$path = ltrim($path, '/');
$path = trim($path);

// Debug info (remove in production)
if (isset($_GET['debug'])) {
    echo "<h3>Debug Info:</h3>";
    echo "<p>Request URI: " . $_SERVER['REQUEST_URI'] . "</p>";
    echo "<p>Parsed Path: '$path'</p>";
    echo "<hr>";
}

// Basic routing
switch($path) {
    case '':
    case 'index.php':
        // Serve the homepage with correct content type
        header('Content-Type: text/html');
        readfile('public/index.html');
        break;
        
    case 'test':
    case 'test.php':
        if (file_exists('api/test.php')) {
            include 'api/test.php';
        } else {
            http_response_code(404);
            echo "Test file not found";
        }
        break;
        
    case 'setup_database':
    case 'setup_database.php':
        if (file_exists('api/setup_database.php')) {
            include 'api/setup_database.php';
        } else {
            http_response_code(404);
            echo "Setup database file not found";
        }
        break;
        
    case 'booking':
    case 'booking.php':
        if (file_exists('api/booking.php')) {
            include 'api/booking.php';
        } else {
            http_response_code(404);
            echo "Booking file not found";
        }
        break;
        
    case 'dashboard':
    case 'dashboard.php':
        if (file_exists('api/dashboard.php')) {
            include 'api/dashboard.php';
        } else {
            http_response_code(404);
            echo "Dashboard file not found";
        }
        break;
        
    case 'login':
    case 'login.php':
        if (file_exists('api/login.php')) {
            include 'api/login.php';
        } else {
            http_response_code(404);
            echo "Login file not found";
        }
        break;
        
    case 'logout':
    case 'logout.php':
        if (file_exists('api/logout.php')) {
            include 'api/logout.php';
        } else {
            http_response_code(404);
            echo "Logout file not found";
        }
        break;
        
    // Handle static files
    case 'styles.css':
        header('Content-Type: text/css');
        readfile('public/styles.css');
        break;
        
    case 'script.js':
        header('Content-Type: application/javascript');
        readfile('public/script.js');
        break;
        
    default:
        // Try to serve static files from public directory
        $file_path = 'public/' . $path;
        if (file_exists($file_path) && is_file($file_path)) {
            $mime_type = mime_content_type($file_path);
            header('Content-Type: ' . $mime_type);
            readfile($file_path);
        } else {
            http_response_code(404);
            echo "<h1>404 - Page Not Found</h1>";
            echo "<p>The requested path '$path' was not found.</p>";
            echo "<p><a href='/'>Go to Homepage</a></p>";
        }
        break;
}
?>
