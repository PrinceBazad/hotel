@echo off
echo ====================================
echo   Luxury Hotel Website Deployment
echo ====================================
echo.

echo Checking if Vercel CLI is installed...
vercel --version >nul 2>&1
if errorlevel 1 (
    echo Vercel CLI not found. Installing...
    npm install -g vercel
    if errorlevel 1 (
        echo Error: Failed to install Vercel CLI
        echo Please install Node.js first from https://nodejs.org/
        pause
        exit /b 1
    )
) else (
    echo Vercel CLI is already installed!
)

echo.
echo Logging in to Vercel...
vercel login

echo.
echo Deploying to Vercel...
vercel --prod

echo.
echo ====================================
echo   Deployment Complete!
echo ====================================
echo.
echo Your website should now be live!
echo Don't forget to:
echo 1. Set up environment variables in Vercel dashboard
echo 2. Visit /api/setup.php to initialize database
echo 3. Test all functionality
echo.
pause
