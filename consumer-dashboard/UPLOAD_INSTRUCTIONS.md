# 🚀 Upload Instructions for dashboard.dhealthrides.com

## ✅ Files Ready for Upload

Your static files are ready in the `out/` directory. All files need to be uploaded to:
```
/home/u797419600/domains/dhealthrides.com/public_html/consumer-dash/
```

## 📁 What to Upload

Upload **ALL** contents from the `out/` folder:
- `index.html` (main entry point)
- `_next/` folder (contains all JavaScript and CSS)
- `dashboard/`, `orders/`, `profile/`, `settings/`, `tests/` folders
- `404.html` and other files
- `.htaccess` (for proper routing)

## 🔧 Upload Methods

### Method 1: cPanel File Manager (Recommended)
1. Login to your cPanel
2. Open **File Manager**
3. Navigate to `/public_html/consumer-dash/`
4. Delete any existing files in this directory
5. Upload all files from the `out/` folder
6. Make sure `index.html` is in the root of `consumer-dash/`

### Method 2: FTP/SFTP
```bash
# Example SFTP command (replace with your actual credentials)
sftp your-username@your-server.com
cd /home/u797419600/domains/dhealthrides.com/public_html/consumer-dash/
put -r out/* .
```

### Method 3: ZIP Upload
1. Create a ZIP file of all contents in the `out/` folder
2. Upload the ZIP file to `/public_html/consumer-dash/`
3. Extract the ZIP file in the destination folder
4. Delete the ZIP file after extraction

## 🔍 Verify Upload

After uploading, your directory structure should look like:
```
/home/u797419600/domains/dhealthrides.com/public_html/consumer-dash/
├── index.html
├── .htaccess
├── _next/
│   ├── static/
│   └── ...
├── dashboard/
├── orders/
├── profile/
├── settings/
└── tests/
```

## 🌐 Test Your Deployment

After upload, test these URLs:
- ✅ https://dashboard.dhealthrides.com (should show dashboard login/home)
- ✅ https://dashboard.dhealthrides.com/dashboard (main dashboard)
- ✅ https://dashboard.dhealthrides.com/orders (orders page)
- ✅ https://dashboard.dhealthrides.com/profile (profile page)

## 🔧 Troubleshooting

### If pages show 404 errors:
1. Ensure `.htaccess` file is uploaded and in the root directory
2. Check that your hosting supports `.htaccess` redirects
3. Verify all files are in the correct directory

### If styles/JavaScript don't load:
1. Check that the `_next/` folder is uploaded correctly
2. Ensure file permissions are correct (644 for files, 755 for folders)
3. Clear browser cache and try again

### If subdomain doesn't work:
1. Verify subdomain is pointing to the correct directory
2. Check DNS propagation (can take up to 24 hours)
3. Ensure SSL certificate covers the subdomain

## ⚡ Quick Commands

```bash
# From the consumer-dashboard directory
cd out/
ls -la  # Verify all files are present

# Create a ZIP for upload
zip -r dashboard-files.zip *
```

## 📞 Support

If you encounter issues:
1. Check browser console for JavaScript errors
2. Verify server error logs in cPanel
3. Test with a simple `index.html` first to ensure subdomain works
4. Contact your hosting provider if subdomain routing issues persist

Your dashboard should be live at **https://dashboard.dhealthrides.com** after successful upload! 🎉 