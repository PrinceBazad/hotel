<?php
require_once 'config.php';

enableCORS();
session_start();

$conn = getDbConnection();
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $data = getJsonInput();
    $action = $data['action'] ?? '';
    
    if ($action === 'login') {
        $email = mysqli_real_escape_string($conn, $data['email']);
        $password = $data['password'];
        
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_email'] = $row['email'];
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Login successful',
                    'user' => [
                        'id' => $row['id'],
                        'name' => $row['name'],
                        'email' => $row['email']
                    ]
                ]);
            } else {
                http_response_code(401);
                echo json_encode(['error' => 'Invalid password']);
            }
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
        }
    }
    
    elseif ($action === 'signup') {
        $name = mysqli_real_escape_string($conn, $data['name']);
        $email = mysqli_real_escape_string($conn, $data['email']);
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $phone = mysqli_real_escape_string($conn, $data['phone']);
        
        // Check if email exists
        $checkEmail = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($checkEmail);
        
        if ($result->num_rows > 0) {
            http_response_code(409);
            echo json_encode(['error' => 'Email already exists']);
        } else {
            $sql = "INSERT INTO users (name, email, password, phone) VALUES ('$name', '$email', '$password', '$phone')";
            
            if ($conn->query($sql) === TRUE) {
                echo json_encode(['success' => true, 'message' => 'Account created successfully']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Error creating account']);
            }
        }
    }
    
    elseif ($action === 'logout') {
        session_destroy();
        echo json_encode(['success' => true, 'message' => 'Logged out successfully']);
    }
}

$conn->close();
?>
