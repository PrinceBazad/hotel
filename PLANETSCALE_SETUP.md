# 🚀 PlanetScale Database Setup for Hotel Website

## Why PlanetScale?
✅ **FREE TIER** - Perfect for your hotel website  
✅ **5GB Storage** - More than enough for hotel bookings  
✅ **1 billion reads/month** - Handles lots of traffic  
✅ **MySQL Compatible** - Works with your existing PHP code  
✅ **No Credit Card Required** for free tier  
✅ **Global Scale** - Fast worldwide  

## 📋 Step-by-Step Setup:

### 1. **Create PlanetScale Account**
- Go to [planetscale.com](https://planetscale.com)
- Click "Sign up for free"
- Use GitHub account (easiest)

### 2. **Create Your Database**
- Click "Create database"
- Database name: `hotel-booking`
- Region: Choose closest to your users
- Click "Create database"

### 3. **Create Password for Connection**
- In your database dashboard, click "Connect"
- Click "Create password"
- Name: `hotel-website-connection`
- Role: Can read & write
- Click "Create password"

### 4. **Copy Connection Details**
You'll see something like:
```
Host: aws.connect.psdb.cloud
Username: abc123xyz
Password: pscale_pw_xyz789
Database: hotel-booking
Port: 3306
```

**⚠️ IMPORTANT: Copy these details immediately - the password won't be shown again!**

### 5. **Set Environment Variables in Vercel**
In Vercel Dashboard → Your Project → Settings → Environment Variables:

```
DB_HOST=aws.connect.psdb.cloud
DB_USER=abc123xyz
DB_PASS=pscale_pw_xyz789
DB_NAME=hotel-booking
```

### 6. **Initialize Database Tables**
After deployment, visit:
`https://your-vercel-app.vercel.app/api/setup.php`

This will create:
- `users` table (for customer accounts)
- `bookings` table (for room reservations)

## 🎯 **Testing Your Setup:**

### Test Database Connection:
Visit: `https://your-app.vercel.app/api/setup.php`
✅ Should show: "Database setup completed successfully!"

### Test User Registration:
1. Go to your hotel website
2. Click "Login" → "Sign up here"  
3. Create a test account
4. ✅ Should redirect to dashboard

### Test Room Booking:
1. Login to your account
2. Click "Book Now" on any room
3. Fill in dates and details  
4. Click "Book Now"
5. ✅ Should show success message

## 🔍 **Monitor Your Database:**

### PlanetScale Dashboard:
- **Insights** tab: See query performance
- **Branches** tab: Manage database versions
- **Settings** tab: View usage stats

### Free Tier Limits:
- ✅ **Storage**: 5GB (thousands of bookings)
- ✅ **Reads**: 1 billion/month (unlimited for hotels)  
- ✅ **Writes**: 10 million/month (plenty for bookings)
- ✅ **Branches**: 1 production branch

## 🚨 **Troubleshooting:**

### "Connection failed" error:
1. Check environment variables are set correctly
2. Verify password hasn't expired
3. Check database name matches exactly

### "Database doesn't exist" error:
1. Make sure you created the database
2. Check DB_NAME environment variable
3. Visit `/api/setup.php` first

### Tables not created:
1. Visit `/api/setup.php`  
2. Check Vercel function logs
3. Verify user has write permissions

## 💡 **Pro Tips:**

### For Development:
- Use PlanetScale's branching feature
- Create a `development` branch for testing

### For Production:
- Monitor usage in PlanetScale dashboard
- Set up alerts for high usage
- Consider upgrading if you exceed free tier

### Backup Strategy:
- PlanetScale automatically backs up your data
- You can create manual snapshots
- Export data anytime via CLI

## 🎉 **You're All Set!**

Your hotel website now has:
- ✅ Professional MySQL database
- ✅ Global scale and performance  
- ✅ Automatic backups
- ✅ Zero maintenance required
- ✅ Room for massive growth

**Your luxury hotel booking system is production-ready! 🏨✨**
