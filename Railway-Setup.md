# Railway Deployment Setup Guide

## Dual Environment Setup

Your project is now configured to work both locally and on Railway automatically!

### Local Development
- Uses local MySQL database (127.0.0.1:3306)
- APP_ENV=local, APP_DEBUG=true
- APP_URL=http://localhost

### Railway Deployment (Auto-configured)
When you push to Railway, the application automatically detects the Railway environment and switches to production settings:

#### Database Variables (Auto-provided by Railway)
- **MYSQLHOST** - Database host
- **MYSQLPORT** - Database port  
- **MYSQLDATABASE** - Database name
- **MYSQLUSER** - Database username
- **MYSQLPASSWORD** - Database password

#### Application Variables (Set in Railway Dashboard)
- **APP_ENV** - Set to `production`
- **APP_DEBUG** - Set to `false` 
- **LOG_LEVEL** - Set to `info`
- **RAILWAY_STATIC_URL** - Set to `${{RAILWAY_STATIC_URL}}`

### How It Works

The `AppServiceProvider` automatically detects when running on Railway (by checking for `RAILWAY_STATIC_URL`) and overrides the local configuration with Railway-specific settings. No manual configuration changes needed!

### Optional Environment Variables

You can also set these if needed:

- **APP_NAME** - Your application name
- **APP_URL** - Your application URL (Railway will provide this)
- **MAIL_MAILER** - Set to `log` for production
- **CACHE_DRIVER** - Set to `file` or `redis` if using Redis
- **SESSION_DRIVER** - Set to `file` or `database`

## Deployment Steps

1. Push your code to GitHub
2. Connect your GitHub repository to Railway
3. In Railway dashboard, go to Environment Variables
4. Add the required environment variables listed above
5. Deploy your application

## Troubleshooting

If you encounter database connection issues:

1. Check that `DATABASE_URL` is properly set by Railway
2. Verify your `config/database.php` supports URL-based connections
3. Ensure migrations run successfully during deployment

## Procfile

The Procfile is configured to:
- Run migrations automatically
- Start the PHP development server on the correct port

## railway.json

This file provides Railway with deployment instructions including:
- Build commands
- Start commands
- Environment variable defaults
- MySQL database service configuration (version 8.0)
