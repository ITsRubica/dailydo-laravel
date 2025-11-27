# Admin Account Setup

This guide will help you set up an admin account for the DailyDo Laravel application.

## Creating an Admin Account

### Method 1: Using Database Seeder (Recommended)

Run the following command to create the default admin account:

```bash
php artisan db:seed --class=AdminUserSeeder
```

This will create an admin account with the following credentials:
- **Email:** admin@dailydo.com
- **Password:** admin123
- **Username:** admin

**Important:** Change the password after first login!

### Method 2: Manual Database Update

If you already have a user account and want to make it an admin:

1. Connect to your database
2. Run the following SQL query (replace `your-email@example.com` with the user's email):

```sql
UPDATE users SET role = 'admin' WHERE email = 'your-email@example.com';
```

### Method 3: Using Tinker

You can also create an admin user using Laravel Tinker:

```bash
php artisan tinker
```

Then run:

```php
$user = new App\Models\User();
$user->username = 'admin';
$user->email = 'admin@dailydo.com';
$user->password = Hash::make('admin123');
$user->first_name = 'Admin';
$user->last_name = 'User';
$user->role = 'admin';
$user->bio = 'System Administrator';
$user->save();
```

## Admin Features

Admin accounts have access to:

1. **Profile Page** - View and edit admin profile
2. **User Management** - View, edit, and delete users

### User Management Features:

- View all registered users
- Search users by name or email
- View detailed user information
- Edit user details (username, email)
- Delete users (except other admins)
- View statistics:
  - Total users
  - Active users (users who created tasks in the last 7 days)
  - New users this month

## Accessing Admin Panel

1. Login with admin credentials at `/login`
2. You will be redirected to the User Management page
3. The sidebar will show:
   - Profile
   - User Management

## Security Notes

- Admin users cannot be deleted through the user management interface
- Only authenticated users with `role = 'admin'` can access admin routes
- The admin middleware (`AdminMiddleware`) protects all admin routes
- Always use strong passwords for admin accounts
- Change default credentials immediately after first login

## Troubleshooting

### "Access denied. Admin privileges required."

This error means:
- You're not logged in, OR
- Your user account doesn't have `role = 'admin'`

Solution: Check your user's role in the database:

```sql
SELECT id, username, email, role FROM users WHERE email = 'your-email@example.com';
```

If the role is not 'admin', update it:

```sql
UPDATE users SET role = 'admin' WHERE email = 'your-email@example.com';
```

### Admin routes not working

Make sure the admin middleware is registered in `app/Http/Kernel.php`:

```php
protected $middlewareAliases = [
    // ... other middleware
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
];
```

## Routes

Admin routes are prefixed with `/admin`:

- `GET /admin` - User Management Dashboard
- `PUT /admin/users/{user}` - Update user
- `DELETE /admin/users/{user}` - Delete user
