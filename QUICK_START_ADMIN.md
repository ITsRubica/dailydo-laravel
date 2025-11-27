# Quick Start: Admin Account

## Create Admin Account (3 Simple Steps)

### Step 1: Run the Seeder
```bash
php artisan db:seed --class=AdminUserSeeder
```

### Step 2: Login
Visit: `http://your-app-url/login`

**Credentials:**
- Email: `admin@dailydo.com`
- Password: `admin123`

### Step 3: Change Password (Important!)
1. Click "Profile" in the sidebar
2. Click "Change Password"
3. Enter current password: `admin123`
4. Enter and confirm your new secure password
5. Click "Change Password"

## What You Get

### Admin Panel Features:
- **User Management Dashboard** at `/admin`
  - View all registered users
  - Search users by name or email
  - View user statistics (Total, Active, New This Month)
  - Click any user to view details
  - Edit user information (username, email)
  - Delete users (except other admins)

### Admin Sidebar:
- Profile
- User Management

## Alternative: Make Existing User Admin

If you already have an account and want to make it admin:

### Option 1: Database Query
```sql
UPDATE users SET role = 'admin' WHERE email = 'your-email@example.com';
```

### Option 2: Laravel Tinker
```bash
php artisan tinker
```
```php
$user = User::where('email', 'your-email@example.com')->first();
$user->role = 'admin';
$user->save();
```

## Troubleshooting

**"Access denied. Admin privileges required."**
- Your account doesn't have admin role
- Run: `UPDATE users SET role = 'admin' WHERE email = 'your-email@example.com';`

**Can't see User Management in sidebar**
- Make sure you're logged in as admin
- Check your role in database: `SELECT role FROM users WHERE email = 'your-email@example.com';`

**Admin routes not working**
- Clear cache: `php artisan cache:clear`
- Clear config: `php artisan config:clear`
- Clear route cache: `php artisan route:clear`

## Security Reminders

✅ Change default password immediately  
✅ Use strong passwords for admin accounts  
✅ Don't share admin credentials  
✅ Admin accounts cannot be deleted through the UI  
✅ All admin routes are protected by middleware  

## Need More Help?

See `ADMIN_SETUP.md` for detailed documentation.
