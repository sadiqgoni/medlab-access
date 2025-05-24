# Admin User Setup Guide

This document outlines secure methods to create admin users for the DHR SPACE application.

## 🚀 Method 1: Artisan Command (Recommended)

This is the most secure and user-friendly method. Use this for creating admin users on production servers.

### Interactive Mode
```bash
php artisan admin:create
```

The command will prompt you for:
- Admin Name
- Admin Email
- Phone Number (optional)
- Password (hidden input)
- Password Confirmation

### Non-Interactive Mode
```bash
php artisan admin:create --name="John Doe" --email="admin@dhrspace.com" --password="SecurePassword123!" --phone="+1234567890"
```

### Features
- ✅ Input validation
- ✅ Password confirmation
- ✅ Checks for existing admin users
- ✅ Secure password handling
- ✅ Email uniqueness validation
- ✅ Clear success/error messages

---

## 🔧 Method 2: Database Seeder

Use this method during initial application setup or development.

### Option A: Using Environment Variables

1. Add these variables to your `.env` file:
```env
CREATE_ADMIN_USER=true
ADMIN_NAME="System Administrator"
ADMIN_EMAIL="admin@dhrspace.com"
ADMIN_PASSWORD="SecurePassword123!"
ADMIN_PHONE="+1234567890"
```

2. Run the main seeder:
```bash
php artisan db:seed
```

### Option B: Run Dedicated Admin Seeder

1. Set environment variables (same as above)
2. Run only the admin seeder:
```bash
php artisan db:seed --class=AdminSeeder
```

---

## 🛡️ Security Best Practices

### For Production Servers:
1. **Use Method 1 (Artisan Command)** - Most secure
2. **SSH into your server** and run the command directly
3. **Use strong passwords** (minimum 12 characters, mixed case, numbers, symbols)
4. **Change default passwords immediately** after first login
5. **Remove admin creation seeders** from production database seeds

### For Development:
- You can use any method
- Remember to use different credentials than production

---

## 📝 Example Usage Scenarios

### New Production Deployment:
```bash
# SSH into production server
ssh user@your-server.com

# Navigate to application directory
cd /path/to/your/application

# Create admin user
php artisan admin:create
```

### Local Development Setup:
```bash
# Option 1: Quick setup with seeder
echo "CREATE_ADMIN_USER=true" >> .env
php artisan migrate:fresh --seed

# Option 2: Create specific admin
php artisan admin:create --name="Dev Admin" --email="dev@dhrspace.com"
```

### Team Environment:
```bash
# Each team member can create their own admin
php artisan admin:create --name="Jane Smith" --email="jane@company.com"
```

---

## 🔍 Verification

After creating an admin user, verify the setup:

1. **Check the database:**
```bash
php artisan tinker
>>> App\Models\User::where('role', 'admin')->get()
```

2. **Test login:**
- Navigate to `/admin` in your browser
- Use the created credentials to log in
- Verify access to admin panel features

---

## 🚨 Troubleshooting

### Command Not Found:
Make sure you're in the correct directory and run:
```bash
php artisan list | grep admin
```

### Permission Errors:
Ensure your web server has write permissions to the database and log files.

### Email Already Exists:
Use a different email address or delete the existing user first.

### Database Connection Issues:
Verify your `.env` database configuration is correct.

---

## 🔄 Updating Admin Users

To modify existing admin users, you can:

1. **Use the Filament Admin Panel** (if you have access)
2. **Use Laravel Tinker:**
```bash
php artisan tinker
>>> $admin = App\Models\User::where('email', 'admin@dhrspace.com')->first()
>>> $admin->password = Hash::make('NewPassword123!')
>>> $admin->save()
```

3. **Create a new admin and delete the old one:**
```bash
php artisan admin:create  # Create new admin
# Then delete old admin through the admin panel
```

---

## 📋 Post-Setup Checklist

- [ ] Admin user created successfully
- [ ] Login credentials tested
- [ ] Default password changed (if using seeder)
- [ ] Admin seeder removed from production seeds
- [ ] Environment variables secured
- [ ] Backup admin access method established
- [ ] Team members have necessary access

---

## 🆘 Emergency Access

If you lose admin access:

1. **Create a new admin via command line:**
```bash
php artisan admin:create --email="emergency@dhrspace.com"
```

2. **Reset password via database:**
```bash
php artisan tinker
>>> $user = App\Models\User::where('email', 'existing@admin.com')->first()
>>> $user->password = Hash::make('NewPassword123!')
>>> $user->save()
```

3. **Contact system administrator** if you don't have server access 