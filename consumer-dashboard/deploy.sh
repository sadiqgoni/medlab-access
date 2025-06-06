#!/bin/bash

# DHR SPACE Consumer Dashboard Deployment Script
# This script builds and prepares the dashboard for static hosting

echo "🚀 Starting deployment process..."

# Step 1: Clean previous build
echo "🧹 Cleaning previous build..."
rm -rf out/
rm -rf .next/

# Step 2: Install dependencies
echo "📦 Installing dependencies..."
npm install

# Step 3: Build for production
echo "🔨 Building for production..."
npm run build

echo "✅ Build completed!"
echo ""
echo "📁 Static files are ready in the 'out/' directory"
echo ""
echo "🌐 Next steps for deployment:"
echo "1. Upload all files from 'out/' directory to:"
echo "   /home/u797419600/domains/dhealthrides.com/public_html/consumer-dash/"
echo ""
echo "2. Ensure the following files are in the root of consumer-dash/:"
echo "   - index.html"
echo "   - _next/ folder"
echo "   - All other files from out/"
echo ""
echo "3. Your dashboard will be available at:"
echo "   https://dashboard.dhealthrides.com"
echo ""
echo "📋 Upload Command Example (if using cPanel File Manager):"
echo "   - Compress the 'out/' folder contents"
echo "   - Upload to consumer-dash/ directory"
echo "   - Extract in the destination folder"
echo ""
echo "📋 Upload Command Example (if using FTP/SFTP):"
echo "   scp -r out/* user@yourserver:/home/u797419600/domains/dhealthrides.com/public_html/consumer-dash/" 