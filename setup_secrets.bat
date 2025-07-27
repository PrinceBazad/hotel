@echo off
echo Setting up Vercel secrets for Aiven database...

REM Replace these placeholder values with your actual database credentials
echo YOUR_DB_HOST | vercel secrets add db_host
echo YOUR_DB_USER | vercel secrets add db_user  
echo YOUR_DB_PASSWORD | vercel secrets add db_pass
echo YOUR_DB_NAME | vercel secrets add db_name
echo YOUR_DB_PORT | vercel secrets add db_port

echo All secrets added successfully!
echo Now deploying the project...
vercel --prod
