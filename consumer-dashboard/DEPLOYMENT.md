# 🚀 Consumer Dashboard Deployment Guide

## Production Access Configuration

Your Next.js consumer dashboard can be deployed in several ways to work alongside your existing Laravel application at `https://dhealthrides.com`.

## 📋 **Deployment Options**

### **Option 1: Subdomain Deployment (Recommended)**
Deploy the Next.js app on a subdomain:
```
Current: https://dhealthrides.com/consumer/orders/create
New:     https://dashboard.dhealthrides.com
```

**Benefits:**
- Clean separation of concerns
- Easy SSL management
- Independent scaling
- No route conflicts

**Setup:**
1. Create subdomain `dashboard.dhealthrides.com` pointing to your server
2. Deploy Next.js app to a separate directory
3. Configure web server (Apache/Nginx) to serve the subdomain

### **Option 2: Path-based Deployment**
Deploy under a specific path:
```
Current: https://dhealthrides.com/consumer/orders/create
New:     https://dhealthrides.com/dashboard/
```

**Benefits:**
- Same domain
- Unified user experience
- Easier session management

**Setup requires Next.js configuration:**
```typescript
// next.config.ts
const nextConfig: NextConfig = {
  basePath: '/dashboard',
  assetPrefix: '/dashboard',
  // ... other config
};
```

### **Option 3: Replace Consumer Routes**
Replace existing consumer section entirely:
```
Current: https://dhealthrides.com/consumer/orders/create
New:     https://dhealthrides.com/consumer/
```

**Benefits:**
- Seamless upgrade
- Maintain existing URLs
- Progressive migration

## 🛠️ **Server Configuration**

### **For Apache (.htaccess)**
```apache
# For subdomain (dashboard.dhealthrides.com)
<VirtualHost *:443>
    ServerName dashboard.dhealthrides.com
    DocumentRoot /var/www/consumer-dashboard
    
    # Proxy to Next.js server
    ProxyPass / http://localhost:3000/
    ProxyPassReverse / http://localhost:3000/
    
    SSLEngine on
    SSLCertificateFile /path/to/certificate.crt
    SSLCertificateKeyFile /path/to/private.key
</VirtualHost>

# For path-based (/dashboard)
RewriteEngine On
RewriteRule ^dashboard/(.*) http://localhost:3000/$1 [P,L]
ProxyPassReverse /dashboard/ http://localhost:3000/
```

### **For Nginx**
```nginx
# For subdomain
server {
    listen 443 ssl;
    server_name dashboard.dhealthrides.com;
    
    ssl_certificate /path/to/certificate.crt;
    ssl_certificate_key /path/to/private.key;
    
    location / {
        proxy_pass http://localhost:3000;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}

# For path-based
location /dashboard/ {
    proxy_pass http://localhost:3000/;
    proxy_set_header Host $host;
    proxy_set_header X-Real-IP $remote_addr;
}
```

## 🔧 **Production Deployment Steps**

### **1. Prepare Production Build**
```bash
cd consumer-dashboard
npm run build
```

### **2. Start Production Server**
```bash
# Option A: Using npm (port 3000)
npm start

# Option B: Using PM2 (recommended)
npm install -g pm2
pm2 start npm --name "consumer-dashboard" -- start
pm2 startup
pm2 save

# Option C: Custom port
PORT=3001 npm start
```

### **3. Environment Variables**
Create `.env.production`:
```env
NODE_ENV=production
NEXT_PUBLIC_API_URL=https://dhealthrides.com/api
PORT=3000
```

### **4. SSL Configuration**
Since your main site has SSL, ensure the dashboard also uses HTTPS:
- Use same SSL certificate for subdomain
- Configure reverse proxy with SSL termination

## 🔗 **API Integration**

Update your Laravel routes to serve the dashboard API:
```php
// routes/api.php
Route::prefix('consumer')->group(function () {
    Route::get('/dashboard/stats', [DashboardController::class, 'getStats']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store']);
    // ... other API routes
});
```

## 🌐 **DNS Configuration**

### **For Subdomain Option:**
Add A record or CNAME:
```
dashboard.dhealthrides.com → YOUR_SERVER_IP
```

### **For Path-based Option:**
No DNS changes needed, just server configuration.

## 📱 **Testing Access**

After deployment, test these URLs:
```
✅ https://dashboard.dhealthrides.com (subdomain)
✅ https://dhealthrides.com/dashboard/ (path-based)
✅ https://dhealthrides.com/consumer/ (replacement)
```

## 🔒 **Security Considerations**

1. **CORS Configuration**: Update Laravel CORS settings
2. **Session Management**: Ensure sessions work across domains
3. **API Authentication**: Configure JWT/session tokens
4. **Rate Limiting**: Apply to API endpoints

## 📊 **Monitoring**

```bash
# Check application status
pm2 status
pm2 logs consumer-dashboard

# Monitor server resources
htop
df -h
```

## 🔄 **Deployment Script**

Create `deploy.sh`:
```bash
#!/bin/bash
cd /var/www/consumer-dashboard
git pull origin main
npm ci --production
npm run build
pm2 restart consumer-dashboard
echo "✅ Consumer Dashboard deployed successfully!"
```

---

## 🎯 **Recommended Setup for dhealthrides.com**

Based on your current setup, I recommend **Option 1 (Subdomain)** with:
- **URL**: `https://dashboard.dhealthrides.com`
- **Port**: 3000 (internal)
- **Process Manager**: PM2
- **SSL**: Shared certificate with main domain

This gives you the cleanest separation while maintaining a professional appearance! 🏥✨ 