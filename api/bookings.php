<?php
require_once 'config.php';

enableCORS();
session_start();

$conn = getDbConnection();
$method = $_SERVER['REQUEST_METHOD'];

// Room details
$rooms = [
    'deluxe' => ['name' => 'Deluxe Room', 'price' => 199],
    'suite' => ['name' => 'Executive Suite', 'price' => 299],
    'presidential' => ['name' => 'Presidential Suite', 'price' => 499]
];

if ($method === 'POST') {
    $data = getJsonInput();
    $action = $data['action'] ?? '';
    
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(['error' => 'User not authenticated']);
        exit();
    }
    
    if ($action === 'book') {
        $user_id = $_SESSION['user_id'];
        $room_type = mysqli_real_escape_string($conn, $data['room_type']);
        $check_in = mysqli_real_escape_string($conn, $data['check_in']);
        $check_out = mysqli_real_escape_string($conn, $data['check_out']);
        $guests = intval($data['guests']);
        $special_requests = mysqli_real_escape_string($conn, $data['special_requests'] ?? '');
        
        // Calculate total price
        $days = (strtotime($check_out) - strtotime($check_in)) / (60 * 60 * 24);
        $room_price = $rooms[$room_type]['price'];
        $total_price = $days * $room_price;
        
        // Check availability
        $checkAvailability = "SELECT * FROM bookings WHERE room_type = '$room_type' 
                             AND ((check_in <= '$check_in' AND check_out > '$check_in') 
                             OR (check_in < '$check_out' AND check_out >= '$check_out') 
                             OR (check_in >= '$check_in' AND check_out <= '$check_out'))
                             AND status != 'cancelled'";
        
        $result = $conn->query($checkAvailability);
        
        if ($result->num_rows > 0) {
            http_response_code(409);
            echo json_encode(['error' => 'Room not available for selected dates']);
        } else {
            $sql = "INSERT INTO bookings (user_id, room_type, check_in, check_out, guests, special_requests, total_price, status) 
                    VALUES ('$user_id', '$room_type', '$check_in', '$check_out', '$guests', '$special_requests', '$total_price', 'confirmed')";
            
            if ($conn->query($sql) === TRUE) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Room booked successfully',
                    'total_price' => $total_price
                ]);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Error booking room']);
            }
        }
    }
    
    elseif ($action === 'check_availability') {
        $room_type = mysqli_real_escape_string($conn, $data['room_type']);
        $check_in = mysqli_real_escape_string($conn, $data['check_in']);
        $check_out = mysqli_real_escape_string($conn, $data['check_out']);
        
        $checkAvailability = "SELECT * FROM bookings WHERE room_type = '$room_type' 
                             AND ((check_in <= '$check_in' AND check_out > '$check_in') 
                             OR (check_in < '$check_out' AND check_out >= '$check_out') 
                             OR (check_in >= '$check_in' AND check_out <= '$check_out'))
                             AND status != 'cancelled'";
        
        $result = $conn->query($checkAvailability);
        
        if ($result->num_rows > 0) {
            echo json_encode(['available' => false, 'message' => 'Room not available']);
        } else {
            echo json_encode(['available' => true, 'message' => 'Room is available']);
        }
    }
    
    elseif ($action === 'cancel') {
        $user_id = $_SESSION['user_id'];
        $booking_id = intval($data['booking_id']);
        
        $sql = "UPDATE bookings SET status = 'cancelled' WHERE id = '$booking_id' AND user_id = '$user_id'";
        
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true, 'message' => 'Booking cancelled successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Error cancelling booking']);
        }
    }
}

elseif ($method === 'GET') {
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(['error' => 'User not authenticated']);
        exit();
    }
    
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM bookings WHERE user_id = '$user_id' ORDER BY booking_date DESC";
    $result = $conn->query($sql);
    
    $bookings = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $bookings[] = $row;
        }
    }
    
    echo json_encode(['bookings' => $bookings]);
}

$conn->close();
?>
