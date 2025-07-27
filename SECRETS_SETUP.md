# Database Secrets Setup

## Important Security Notice
The database credentials have been removed from the repository for security reasons.

## Setup Instructions

1. **Copy the template file:**
   ```bash
   copy setup_secrets.bat setup_secrets_local.bat
   ```

2. **Edit `setup_secrets_local.bat`** with your actual database credentials:
   - Replace `YOUR_DB_HOST` with your Aiven database host
   - Replace `YOUR_DB_USER` with your database username
   - Replace `YOUR_DB_PASSWORD` with your database password
   - Replace `YOUR_DB_NAME` with your database name
   - Replace `YOUR_DB_PORT` with your database port

3. **Run the local setup script:**
   ```bash
   setup_secrets_local.bat
   ```

## Vercel Configuration
The `vercel.json` file is configured to use Vercel secrets. After running the setup script above, your environment variables will be properly configured.

## Security Notes
- Never commit files containing actual credentials
- The `setup_secrets_local.bat` file is automatically ignored by git
- Always use environment variables or secret management for sensitive data
