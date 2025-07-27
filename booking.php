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

$message = '';
$messageType = '';

// Get room type from URL parameter
$selectedRoom = isset($_GET['room']) ? $_GET['room'] : '';

// Room details
$rooms = [
    'deluxe' => ['name' => 'Deluxe Room', 'price' => 199],
    'suite' => ['name' => 'Executive Suite', 'price' => 299],
    'presidential' => ['name' => 'Presidential Suite', 'price' => 499]
];

// Handle booking
if (isset($_POST['book_room'])) {
    $user_id = $_SESSION['user_id'];
    $room_type = mysqli_real_escape_string($conn, $_POST['room_type']);
    $check_in = mysqli_real_escape_string($conn, $_POST['check_in']);
    $check_out = mysqli_real_escape_string($conn, $_POST['check_out']);
    $guests = intval($_POST['guests']);
    $special_requests = mysqli_real_escape_string($conn, $_POST['special_requests']);
    
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
        $message = "Sorry, this room is not available for the selected dates.";
        $messageType = "error";
    } else {
        // Book the room
        $sql = "INSERT INTO bookings (user_id, room_type, check_in, check_out, guests, special_requests, total_price, status) 
                VALUES ('$user_id', '$room_type', '$check_in', '$check_out', '$guests', '$special_requests', '$total_price', 'confirmed')";
        
        if ($conn->query($sql) === TRUE) {
            $message = "Room booked successfully! Total: $" . number_format($total_price, 2);
            $messageType = "success";
        } else {
            $message = "Error booking room: " . $conn->error;
            $messageType = "error";
        }
    }
}

// Check availability function
if (isset($_POST['check_availability'])) {
    $room_type = mysqli_real_escape_string($conn, $_POST['room_type']);
    $check_in = mysqli_real_escape_string($conn, $_POST['check_in']);
    $check_out = mysqli_real_escape_string($conn, $_POST['check_out']);
    
    $checkAvailability = "SELECT * FROM bookings WHERE room_type = '$room_type' 
                         AND ((check_in <= '$check_in' AND check_out > '$check_in') 
                         OR (check_in < '$check_out' AND check_out >= '$check_out') 
                         OR (check_in >= '$check_in' AND check_out <= '$check_out'))
                         AND status != 'cancelled'";
    
    $result = $conn->query($checkAvailability);
    
    if ($result->num_rows > 0) {
        $message = "Room is not available for the selected dates.";
        $messageType = "error";
    } else {
        $message = "Great! Room is available for your dates.";
        $messageType = "success";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Room - Luxury Hotel</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        .booking-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 100px 20px 50px;
        }

        .booking-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: start;
        }

        .booking-form {
            background: white;
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            animation: slideInLeft 0.6s ease-out;
        }

        .room-preview {
            background: white;
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            animation: slideInRight 0.6s ease-out;
        }

        @keyframes slideInLeft {
            0% {
                opacity: 0;
                transform: translateX(-50px);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            0% {
                opacity: 0;
                transform: translateX(50px);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .page-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .page-header h1 {
            font-size: 3rem;
            color: #2c3e50;
            margin-bottom: 1rem;
        }

        .page-header p {
            font-size: 1.2rem;
            color: #666;
        }

        .form-section {
            margin-bottom: 2rem;
        }

        .form-section h3 {
            font-size: 1.5rem;
            color: #2c3e50;
            margin-bottom: 1rem;
            border-bottom: 2px solid #e74c3c;
            padding-bottom: 0.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #2c3e50;
            font-weight: 600;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e1e8ed;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #e74c3c;
            box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.1);
            transform: scale(1.02);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .availability-btn,
        .booking-btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-right: 1rem;
        }

        .availability-btn {
            background: linear-gradient(45deg, #3498db, #2980b9);
            color: white;
        }

        .availability-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(52, 152, 219, 0.4);
        }

        .booking-btn {
            background: linear-gradient(45deg, #e74c3c, #f39c12);
            color: white;
        }

        .booking-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(231, 76, 60, 0.4);
        }

        .room-card-preview {
            text-align: center;
        }

        .room-image-preview {
            height: 200px;
            border-radius: 15px;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .room-placeholder-preview {
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            image-rendering: -webkit-optimize-contrast;
            image-rendering: crisp-edges;
            image-rendering: high-quality;
            transition: transform 0.3s ease;
        }

        .deluxe-preview {
            background: url('static/delux.jpeg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            image-rendering: -webkit-optimize-contrast;
            image-rendering: crisp-edges;
            image-rendering: high-quality;
        }

        .suite-preview {
            background: url('static/executive.webp');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            image-rendering: -webkit-optimize-contrast;
            image-rendering: crisp-edges;
            image-rendering: high-quality;
        }

        .presidential-preview {
            background: url('static/presidental.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            image-rendering: -webkit-optimize-contrast;
            image-rendering: crisp-edges;
            image-rendering: high-quality;
        }

        .room-details {
            text-align: left;
        }

        .room-details h3 {
            font-size: 2rem;
            color: #2c3e50;
            margin-bottom: 1rem;
        }

        .room-price-large {
            font-size: 2.5rem;
            color: #e74c3c;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .room-features-list {
            list-style: none;
            margin: 1rem 0;
        }

        .room-features-list li {
            padding: 0.5rem 0;
            color: #666;
            font-size: 1.1rem;
        }

        .message {
            padding: 1rem;
            margin-bottom: 2rem;
            border-radius: 10px;
            text-align: center;
            font-weight: 600;
            animation: slideInDown 0.5s ease-out;
        }

        @keyframes slideInDown {
            0% {
                opacity: 0;
                transform: translateY(-30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.98) !important;
        }

        @media (max-width: 768px) {
            .booking-content {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .page-header h1 {
                font-size: 2rem;
            }

            .booking-form,
            .room-preview {
                padding: 2rem;
            }
        }

        .price-calculator {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 10px;
            margin-top: 2rem;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .total-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: #e74c3c;
            border-top: 2px solid #e74c3c;
            padding-top: 1rem;
            margin-top: 1rem;
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
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="logout.php">Logout (<?php echo $_SESSION['user_name']; ?>)</a></li>
            </ul>
        </div>
    </nav>

    <div class="booking-container">
        <div class="page-header">
            <h1>Book Your Perfect Room</h1>
            <p>Experience luxury and comfort like never before</p>
        </div>

        <?php if ($message): ?>
            <div class="message <?php echo $messageType; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="booking-content">
            <div class="booking-form">
                <form method="POST" action="">
                    <div class="form-section">
                        <h3>🏨 Room Selection</h3>
                        <div class="form-group">
                            <label for="room_type">Room Type</label>
                            <select name="room_type" id="room_type" required onchange="updateRoomPreview()">
                                <option value="">Select Room Type</option>
                                <option value="deluxe" <?php echo ($selectedRoom == 'deluxe') ? 'selected' : ''; ?>>
                                    Deluxe Room - $199/night
                                </option>
                                <option value="suite" <?php echo ($selectedRoom == 'suite') ? 'selected' : ''; ?>>
                                    Executive Suite - $299/night
                                </option>
                                <option value="presidential" <?php echo ($selectedRoom == 'presidential') ? 'selected' : ''; ?>>
                                    Presidential Suite - $499/night
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>📅 Dates & Guests</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="check_in">Check-in Date</label>
                                <input type="date" name="check_in" id="check_in" required 
                                       min="<?php echo date('Y-m-d'); ?>" onchange="calculatePrice()">
                            </div>
                            <div class="form-group">
                                <label for="check_out">Check-out Date</label>
                                <input type="date" name="check_out" id="check_out" required 
                                       min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" onchange="calculatePrice()">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="guests">Number of Guests</label>
                            <select name="guests" id="guests" required onchange="calculatePrice()">
                                <option value="">Select Guests</option>
                                <option value="1">1 Guest</option>
                                <option value="2">2 Guests</option>
                                <option value="3">3 Guests</option>
                                <option value="4">4 Guests</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>💬 Special Requests</h3>
                        <div class="form-group">
                            <label for="special_requests">Any Special Requests? (Optional)</label>
                            <textarea name="special_requests" id="special_requests" 
                                    placeholder="Early check-in, late check-out, room preferences, etc."></textarea>
                        </div>
                    </div>

                    <div class="price-calculator" id="priceCalculator" style="display: none;">
                        <h4>Price Breakdown</h4>
                        <div class="price-row">
                            <span>Room Rate per Night:</span>
                            <span id="roomRate">$0</span>
                        </div>
                        <div class="price-row">
                            <span>Number of Nights:</span>
                            <span id="numberOfNights">0</span>
                        </div>
                        <div class="price-row total-price">
                            <span>Total Price:</span>
                            <span id="totalPrice">$0</span>
                        </div>
                    </div>

                    <div style="margin-top: 2rem;">
                        <button type="submit" name="check_availability" class="availability-btn">
                            Check Availability
                        </button>
                        <button type="submit" name="book_room" class="booking-btn">
                            Book Now
                        </button>
                    </div>
                </form>
            </div>

            <div class="room-preview">
                <div class="room-card-preview">
                    <div class="room-image-preview">
                        <div class="room-placeholder-preview deluxe-preview" id="roomImagePreview"></div>
                    </div>
                    
                    <div class="room-details">
                        <h3 id="roomName">Select a Room</h3>
                        <div class="room-price-large" id="roomPriceDisplay">$0/night</div>
                        
                        <ul class="room-features-list" id="roomFeatures">
                            <li>Select a room to see features</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const roomDetails = {
            'deluxe': {
                name: 'Deluxe Room',
                price: 199,
                class: 'deluxe-preview',
                features: [
                    '✓ Spacious room with city view',
                    '✓ King-size bed',
                    '✓ Free WiFi',
                    '✓ Mini Bar',
                    '✓ 24/7 Room Service',
                    '✓ Air Conditioning'
                ]
            },
            'suite': {
                name: 'Executive Suite',
                price: 299,
                class: 'suite-preview',
                features: [
                    '✓ Luxury suite with separate living area',
                    '✓ Ocean view',
                    '✓ Premium services',
                    '✓ Separate Living Area',
                    '✓ Butler Service',
                    '✓ Executive Lounge Access'
                ]
            },
            'presidential': {
                name: 'Presidential Suite',
                price: 499,
                class: 'presidential-preview',
                features: [
                    '✓ Ultimate luxury experience',
                    '✓ Panoramic views',
                    '✓ Exclusive amenities',
                    '✓ Private Balcony',
                    '✓ Personal Concierge',
                    '✓ Helicopter Pad Access'
                ]
            }
        };

        function updateRoomPreview() {
            const roomType = document.getElementById('room_type').value;
            const roomImage = document.getElementById('roomImagePreview');
            const roomName = document.getElementById('roomName');
            const roomPrice = document.getElementById('roomPriceDisplay');
            const roomFeatures = document.getElementById('roomFeatures');

            if (roomType && roomDetails[roomType]) {
                const room = roomDetails[roomType];
                
                // Update image
                roomImage.className = 'room-placeholder-preview ' + room.class;
                
                // Update details
                roomName.textContent = room.name;
                roomPrice.textContent = '$' + room.price + '/night';
                
                // Update features
                roomFeatures.innerHTML = room.features.map(feature => 
                    '<li>' + feature + '</li>'
                ).join('');

                calculatePrice();
            } else {
                roomName.textContent = 'Select a Room';
                roomPrice.textContent = '$0/night';
                roomFeatures.innerHTML = '<li>Select a room to see features</li>';
                roomImage.className = 'room-placeholder-preview deluxe-preview';
            }
        }

        function calculatePrice() {
            const roomType = document.getElementById('room_type').value;
            const checkIn = document.getElementById('check_in').value;
            const checkOut = document.getElementById('check_out').value;
            const calculator = document.getElementById('priceCalculator');

            if (roomType && checkIn && checkOut && roomDetails[roomType]) {
                const room = roomDetails[roomType];
                const checkInDate = new Date(checkIn);
                const checkOutDate = new Date(checkOut);
                const timeDiff = checkOutDate.getTime() - checkInDate.getTime();
                const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));

                if (daysDiff > 0) {
                    const totalPrice = daysDiff * room.price;
                    
                    document.getElementById('roomRate').textContent = '$' + room.price;
                    document.getElementById('numberOfNights').textContent = daysDiff;
                    document.getElementById('totalPrice').textContent = '$' + totalPrice.toLocaleString();
                    
                    calculator.style.display = 'block';
                    calculator.style.animation = 'slideInUp 0.5s ease-out';
                } else {
                    calculator.style.display = 'none';
                }
            } else {
                calculator.style.display = 'none';
            }
        }

        // Initialize room preview if room is selected from URL
        document.addEventListener('DOMContentLoaded', function() {
            const roomSelect = document.getElementById('room_type');
            if (roomSelect.value) {
                updateRoomPreview();
            }
        });

        // Set minimum date for check-out based on check-in
        document.getElementById('check_in').addEventListener('change', function() {
            const checkIn = new Date(this.value);
            const checkOut = document.getElementById('check_out');
            const minCheckOut = new Date(checkIn);
            minCheckOut.setDate(minCheckOut.getDate() + 1);
            checkOut.min = minCheckOut.toISOString().split('T')[0];
            
            if (checkOut.value && new Date(checkOut.value) <= checkIn) {
                checkOut.value = minCheckOut.toISOString().split('T')[0];
            }
            calculatePrice();
        });

        // Form animations
        document.querySelectorAll('.form-group input, .form-group select, .form-group textarea').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });

        @keyframes slideInUp {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </script>
</body>
</html>
