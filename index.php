<?php
// Main router for the hotel website
$request = $_SERVER['REQUEST_URI'];
$path = parse_url($request, PHP_URL_PATH);

// Remove leading slash
$path = ltrim($path, '/');

// Basic routing
switch($path) {
    case '':
    case 'index.php':
        // Serve the homepage
        readfile('public/index.html');
        break;
        
    case 'test':
    case 'test.php':
        include 'api/test.php';
        break;
        
    case 'setup_database':
    case 'setup_database.php':
        include 'api/setup_database.php';
        break;
        
    case 'booking':
    case 'booking.php':
        include 'api/booking.php';
        break;
        
    case 'dashboard':
    case 'dashboard.php':
        include 'api/dashboard.php';
        break;
        
    case 'login':
    case 'login.php':
        include 'api/login.php';
        break;
        
    case 'logout':
    case 'logout.php':
        include 'api/logout.php';
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
            echo "404 - Page not found";
        }
        break;
}
?>
