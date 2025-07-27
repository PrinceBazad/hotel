# Luxury Hotel Website

A beautiful hotel booking website with user authentication and room booking functionality.

## Features

- **Beautiful Homepage** with animations and responsive design
- **User Authentication** (Login/Signup)
- **Room Booking System** with availability checking
- **User Dashboard** to manage bookings
- **Room Cancellation** functionality
- **Responsive Design** that works on all devices

## Setup Instructions

### 1. Install Required Software

You need to install a local server environment. Choose one of these options:

#### Option A: XAMPP (Recommended)
1. Download XAMPP from: https://www.apachefriends.org/
2. Install XAMPP
3. Start Apache and MySQL services from XAMPP Control Panel

#### Option B: WAMP (Windows)
1. Download WAMP from: http://www.wampserver.com/
2. Install WAMP
3. Start WAMP services

#### Option C: MAMP (Mac)
1. Download MAMP from: https://www.mamp.info/
2. Install MAMP
3. Start MAMP services

### 2. Move Website Files

1. Copy the entire `hotel` folder to your web server directory:
   - **XAMPP**: `C:\xampp\htdocs\hotel`
   - **WAMP**: `C:\wamp64\www\hotel`
   - **MAMP**: `/Applications/MAMP/htdocs/hotel`

### 3. Setup Database

1. Open your web browser
2. Go to: `http://localhost/hotel/setup_database.php`
3. This will create the database and tables automatically
4. You should see "Database setup completed!" message

### 4. Access the Website

1. Go to: `http://localhost/hotel/index.html`
2. Click "Login" to create an account or sign in
3. After logging in, you can book rooms and manage your bookings

## How to Use

### For Users:
1. **Homepage**: Browse the beautiful hotel homepage
2. **Sign Up**: Create a new account with your details
3. **Login**: Sign in with your email and password
4. **Book Room**: Select room type, dates, and guests
5. **Check Availability**: Verify if rooms are available for your dates
6. **Manage Bookings**: View and cancel your bookings from the dashboard

### Room Types Available:
- **Deluxe Room**: $199/night
- **Executive Suite**: $299/night
- **Presidential Suite**: $499/night

## File Structure

```
hotel/
├── index.html          # Homepage
├── styles.css          # All styling and animations
├── script.js           # JavaScript functionality
├── login.php           # Login and signup page
├── booking.php         # Room booking page
├── dashboard.php       # User dashboard
├── logout.php          # Logout functionality
├── setup_database.php  # Database setup
└── README.md           # This file
```

## Troubleshooting

### If you see PHP code instead of the website:
- Make sure your local server (XAMPP/WAMP/MAMP) is running
- Access the site through `http://localhost/hotel/` not by opening files directly
- Check that Apache and MySQL services are started

### If database connection fails:
- Make sure MySQL is running
- Run `setup_database.php` first
- Check database credentials in PHP files (default: root/no password)

### If login doesn't work:
- Make sure you've run the database setup
- Try creating a new account first
- Check that sessions are enabled in PHP

## Browser Compatibility

This website works best on:
- Chrome 60+
- Firefox 55+
- Safari 11+
- Edge 79+

## Features Included

✅ User registration and authentication  
✅ Room availability checking  
✅ Booking system with price calculation  
✅ User dashboard for managing bookings  
✅ Booking cancellation  
✅ Beautiful animations and responsive design  
✅ Secure password hashing  
✅ Session management  

Enjoy your luxury hotel website! 🏨✨
