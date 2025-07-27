# Luxury Hotel Website - Vercel Deployment Guide

## 🚀 Quick Deploy to Vercel

### Option 1: Using Vercel CLI (Recommended)

1. **Install Vercel CLI**:
   ```bash
   npm install -g vercel
   ```

2. **Login to Vercel**:
   ```bash
   vercel login
   ```

3. **Deploy from project directory**:
   ```bash
   cd D:\hotel
   vercel
   ```

4. **Follow the prompts**:
   - Project name: `luxury-hotel-website`
   - Directory: `./` (current directory)
   - Override settings: `N`

### Option 2: GitHub + Vercel Dashboard

1. **Push to GitHub**:
   - Create a new repository on GitHub
   - Push your code:
   ```bash
   git init
   git add .
   git commit -m "Initial commit"
   git remote add origin https://github.com/yourusername/luxury-hotel.git
   git push -u origin main
   ```

2. **Deploy via Vercel Dashboard**:
   - Go to [vercel.com](https://vercel.com)
   - Click "New Project"
   - Import your GitHub repository
   - Vercel will auto-detect and deploy

## 🗄️ Database Setup

### For Production (Recommended):

1. **Use PlanetScale (MySQL)**:
   - Sign up at [planetscale.com](https://planetscale.com)
   - Create a new database
   - Get connection details

2. **Use Railway**:
   - Sign up at [railway.app](https://railway.app)
   - Create MySQL database
   - Get connection details

3. **Use AWS RDS or Google Cloud SQL**:
   - Set up managed MySQL instance
   - Configure security groups/firewall

### Environment Variables:

Set these in Vercel Dashboard → Project → Settings → Environment Variables:

```
DB_HOST=your-database-host
DB_USER=your-database-username  
DB_PASS=your-database-password
DB_NAME=hotel_booking
```

## 🔧 Initial Setup After Deployment

1. **Setup Database**:
   Visit: `https://your-vercel-app.vercel.app/api/setup.php`
   This will create the necessary tables.

2. **Test the API**:
   - Authentication: `/api/auth.php`
   - Bookings: `/api/bookings.php`
   - Setup: `/api/setup.php`

## 📁 Project Structure for Vercel

```
hotel/
├── api/                    # Serverless functions
│   ├── auth.php           # Authentication API
│   ├── bookings.php       # Booking management API
│   ├── config.php         # Database configuration
│   └── setup.php          # Database setup
├── static/                # Room images
│   ├── delux.jpeg
│   ├── executive.webp
│   └── presidental.jpg
├── index.html             # Homepage
├── styles.css             # Styling
├── script.js              # Frontend JavaScript
├── vercel.json            # Vercel configuration
├── package.json           # Dependencies
└── DEPLOYMENT.md          # This file
```

## 🌐 Features Working on Vercel

✅ Static website hosting  
✅ Serverless PHP APIs  
✅ Image hosting  
✅ Environment variables  
✅ Custom domains  
✅ SSL certificates  
✅ CDN acceleration  

## 🔒 Security Notes

- All PHP files are in `/api` directory (serverless functions)
- Database credentials are in environment variables
- CORS is configured for API access
- Session management for authentication

## 🛠️ Local Development

1. **Install Vercel CLI**:
   ```bash
   npm install -g vercel
   ```

2. **Run locally**:
   ```bash
   vercel dev
   ```

3. **Access locally**:
   - Website: `http://localhost:3000`
   - APIs: `http://localhost:3000/api/`

## 📞 Support

If you encounter any issues:
1. Check Vercel function logs in the dashboard
2. Verify environment variables are set
3. Test API endpoints individually
4. Check database connection

## 🚀 Go Live!

After deployment:
1. Your website will be available at: `https://your-project-name.vercel.app`
2. Set up custom domain if needed
3. Configure environment variables
4. Run database setup
5. Test all functionality

**Your luxury hotel website is now ready for the world! 🏨✨**
