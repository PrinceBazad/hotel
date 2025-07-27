# Aiven Database Setup Guide

This guide will help you set up your MySQL database on Aiven for the Luxury Hotel Website.

## Prerequisites
- Aiven account (sign up at [aiven.io](https://aiven.io))
- Basic knowledge of MySQL

## Step 1: Create Aiven MySQL Service

1. **Login to Aiven Console**
   - Go to [console.aiven.io](https://console.aiven.io)
   - Login with your account

2. **Create New Service**
   - Click "Create service"
   - Select "MySQL" as the service type
   - Choose your preferred cloud provider and region
   - Select a service plan (Hobbyist plan is free)
   - Give your service a name (e.g., "hotel-booking-db")

3. **Wait for Service Creation**
   - The service will take a few minutes to initialize
   - Status will change from "Creating" to "Running"

## Step 2: Get Connection Details

Once your service is running:

1. **Access Service Overview**
   - Click on your MySQL service
   - Go to the "Overview" tab

2. **Note Down Connection Details**
   - Service URI
   - Host
   - Port
   - Username
   - Password

## Step 3: Configure Environment Variables

Create a local configuration file with your database credentials:

1. Copy `setup_secrets.bat` to `setup_secrets_local.bat`
2. Edit `setup_secrets_local.bat` with your actual Aiven database credentials
3. Run the script to set up Vercel secrets

## Step 4: Database Schema Setup

The database schema will be automatically created when you first run the application using the `setup_database.php` script.

## Security Notes

- Never commit database credentials to version control
- Use environment variables for sensitive configuration
- Aiven provides SSL/TLS encryption by default
- Consider using connection pooling for production deployments

## Troubleshooting

- Ensure your IP is whitelisted in Aiven (if using IP restrictions)
- Check firewall settings if connection fails
- Verify all credentials are correctly set in environment variables

## Next Steps

After setting up the database:
1. Run `setup_database.php` to create the necessary tables
2. Deploy your application to Vercel
3. Test the booking functionality

For more information, visit the [Aiven Documentation](https://docs.aiven.io/docs/products/mysql).
