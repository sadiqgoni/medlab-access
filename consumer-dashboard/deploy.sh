#!/bin/bash

# DHR SPACE Consumer Dashboard Deployment Script
# Usage: ./deploy.sh [production|staging]

set -e

ENVIRONMENT=${1:-production}
PROJECT_DIR="/var/www/consumer-dashboard"
APP_NAME="consumer-dashboard"

echo "🚀 Starting deployment for $ENVIRONMENT environment..."

# Create directory if it doesn't exist
if [ ! -d "$PROJECT_DIR" ]; then
    echo "📁 Creating project directory: $PROJECT_DIR"
    sudo mkdir -p $PROJECT_DIR
    sudo chown $USER:$USER $PROJECT_DIR
fi

# Navigate to project directory
cd $PROJECT_DIR

# Pull latest code
echo "📦 Pulling latest code..."
if [ -d ".git" ]; then
    git pull origin main
else
    echo "⚠️  Git repository not found. Please clone the repository first:"
    echo "git clone <your-repo-url> $PROJECT_DIR"
    exit 1
fi

# Install dependencies
echo "🔧 Installing dependencies..."
npm ci --production

# Build application
echo "🏗️  Building application..."
npm run build

# Install PM2 if not exists
if ! command -v pm2 &> /dev/null; then
    echo "📦 Installing PM2..."
    npm install -g pm2
fi

# Configure environment
echo "⚙️  Setting up environment..."
cat > .env.production << EOF
NODE_ENV=production
NEXT_PUBLIC_API_URL=https://dhealthrides.com/api
PORT=3000
EOF

# Start/Restart application with PM2
echo "🔄 Starting application with PM2..."
if pm2 describe $APP_NAME > /dev/null 2>&1; then
    echo "♻️  Restarting existing PM2 process..."
    pm2 restart $APP_NAME
else
    echo "🆕 Starting new PM2 process..."
    pm2 start npm --name $APP_NAME -- start
    pm2 startup
    pm2 save
fi

# Health check
echo "🏥 Performing health check..."
sleep 5
if curl -f http://localhost:3000 > /dev/null 2>&1; then
    echo "✅ Application is running successfully!"
    echo "🌐 Your dashboard should be accessible at:"
    echo "   - http://localhost:3000 (internal)"
    echo "   - https://dashboard.dhealthrides.com (if subdomain configured)"
    echo "   - https://dhealthrides.com/dashboard/ (if path-based)"
else
    echo "❌ Health check failed. Check PM2 logs:"
    echo "pm2 logs $APP_NAME"
    exit 1
fi

# Display PM2 status
echo "📊 PM2 Status:"
pm2 status

echo "🎉 Deployment completed successfully!"
echo ""
echo "📝 Next steps:"
echo "1. Configure your web server (Apache/Nginx) to proxy requests"
echo "2. Set up SSL certificate for the subdomain"
echo "3. Test the application at your production URL"
echo ""
echo "🔧 Useful commands:"
echo "  pm2 logs $APP_NAME    # View application logs"
echo "  pm2 restart $APP_NAME # Restart application"
echo "  pm2 stop $APP_NAME    # Stop application" 