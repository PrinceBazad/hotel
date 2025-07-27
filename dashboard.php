<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_booking";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user's bookings
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM bookings WHERE user_id = '$user_id' ORDER BY booking_date DESC";
$result = $conn->query($sql);

$bookings = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
}

// Handle cancel booking
if (isset($_POST['cancel_booking'])) {
    $booking_id = mysqli_real_escape_string($conn, $_POST['booking_id']);
    $sql = "UPDATE bookings SET status = 'cancelled' WHERE id = '$booking_id' AND user_id = '$user_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Booking cancelled successfully";
    } else {
        echo "Error cancelling booking: " . $conn->error;
    }
    header("Location: dashboard.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Luxury Hotel</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        .dashboard-container {
            min-height: 100vh;
            background: #f8f9fa;
            padding: 100px 20px;
        }

        .dashboard-content {
            max-width: 1200px;
            margin: 0 auto;
        }

        .dashboard-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .dashboard-header h1 {
            font-size: 2.5rem;
            color: #2c3e50;
            margin-bottom: 1rem;
        }

        .dashboard-header p {
            font-size: 1.2rem;
            color: #666;
        }

        .booking-list {
            margin-top: 2rem;
            border-collapse: collapse;
            width: 100%;
        }

        .booking-list th,
        .booking-list td {
            text-align: left;
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
        }

        .booking-list th {
            background-color: #f2f2f2;
            color: #333;
        }

        .booking-list tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .booking-list tr:hover {
            background-color: #f1f1f1;
        }

        .cancel-btn {
            padding: 8px 15px;
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .cancel-btn:hover {
            background: #c0392b;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.98) !important;
        }

        @media (max-width: 768px) {
            .dashboard-header h1 {
                font-size: 2rem;
            }

            .booking-list th,
            .booking-list td {
                padding: 10px;
            }

            .cancel-btn {
                padding: 5px 10px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">
                <h2>Luxury Hotel</h2>
            </div>
            <ul class="nav-menu">
                <li><a href="index.html">Home</a></li>
                <li><a href="booking.php">Book a Room</a></li>
                <li><a href="logout.php">Logout (<?php echo $_SESSION['user_name']; ?>)</a></li>
            </ul>
        </div>
    </nav>

    <div class="dashboard-container">
        <div class="dashboard-content">
            <div class="dashboard-header">
                <h1>Welcome, <?php echo $_SESSION['user_name']; ?>!</h1>
                <p>Manage your bookings below.</p>
            </div>

            <?php if (count($bookings) > 0): ?>
                <table class="booking-list">
                    <thead>
                        <tr>
                            <th>Room Type</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking): ?>
                            <tr>
                                <td><?php echo $booking['room_type']; ?></td>
                                <td><?php echo $booking['check_in']; ?></td>
                                <td><?php echo $booking['check_out']; ?></td>
                                <td>$<?php echo $booking['total_price']; ?></td>
                                <td><?php echo ucfirst($booking['status']); ?></td>
                                <td>
                                    <?php if ($booking['status'] != 'cancelled'): ?>
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                                            <button type="submit" name="cancel_booking" class="cancel-btn">Cancel</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No bookings found. <a href="booking.php">Book a room</a> now!</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
