# Admin Role-Based Access Control Setup Guide

This guide explains how to set up and use the admin role-based access control system in DailyDo Laravel.

## Overview

The system implements role-based access control with two roles:
- **Admin**: Can access User Management and Profile pages only
- **User**: Can access Dashboard, Tasks, Calendar, and Profile pages

## Features

✅ Admin users have restricted access (Profile + User Management only)
✅ Regular users cannot access admin pages (403 error)
✅ Sidebar navigation adapts based on user role
✅ User management with view, edit, and delete capabilities
✅ Statistics dashboard for admins
✅ Search and filter functionality

## Quick Setup

### Step 1: Create Admin User

Run the seeder to create the default admin account:

```bash
php artisan db:seed --class=AdminUserSeeder
```

This creates an admin user with:
- **Email**: admin@dailydo.com
- **Password**: admin123
- **Role**: admin

### Step 2: Test the System

Visit the test page to verify everything is working:

```
http://your-app-url/test-roles
```

This page will show:
- Admin users in database
- Regular users in database
- Authentication functions status
- Current session status
- Route access tests
- Database statistics

### Step 3: Login as Admin

1. Go to `/login`
2. Enter email: `admin@dailydo.com`
3. Enter password: `admin123`
4. You'll be redirected to the User Management page

### Step 4: Test Regular User

1. Register a new account at `/register`
2. Login with the new account
3. Try to access `/admin` - you should get a 403 error
4. Notice the sidebar only shows: Profile, Dashboard, Tasks, Calendar

## File Structure

### Models
- `app/Models/User.php` - User model with `isAdmin()` method

### Controllers
- `app/Http/Controllers/AdminController.php` - Admin panel controller

### Middleware
- `app/Http/Middleware/AdminMiddleware.php` - Admin access control

### Views
- `resources/views/admin/dashboard.blade.php` - User management page
- `resources/views/test-roles.blade.php` - Testing page
- `resources/views/layouts/app.blade.php` - Main layout with role-based sidebar

### Database
- `database/migrations/2024_01_14_000000_create_users_table.php` - Users table with role field
- `database/seeders/AdminUserSeeder.php` - Admin user seeder

### Routes
- `routes/web.php` - All routes with admin middleware protection

## Admin Features

### User Management Dashboard

Access: `/admin` or `/admin/dashboard`

Features:
- View all registered users
- See user statistics (Total, Active, New This Month)
- Search users by name or email
- View detailed user information
- Edit user details (username, email)
- Delete users (except admin users)

### User Card Information

Each user card displays:
- User avatar (initials)
- Full name
- Email address
- Registration date
- Role badge (Admin/User)

### User Details Modal

Click any user card to see:
- Full user information
- Edit mode with form validation
- Delete confirmation with warning
- Role-based restrictions (can't delete admins)

## Role-Based Navigation

### Admin Users See:
- Profile
- User Management

### Regular Users See:
- Profile
- Dashboard
- Task List
- Calendar

## API Endpoints

### Admin Routes (Protected by admin middleware)

```php
GET  /admin                    - User management dashboard
GET  /admin/users              - List all users (with search/filter)
GET  /admin/tasks              - List all tasks (with search/filter)
PUT  /admin/users/{user}       - Update user
DELETE /admin/users/{user}     - Delete user
```

## Security Features

1. **Middleware Protection**: All admin routes protected by `AdminMiddleware`
2. **Role Verification**: `isAdmin()` method checks user role
3. **Delete Protection**: Cannot delete admin users
4. **CSRF Protection**: All forms include CSRF tokens
5. **Input Validation**: Email and username validation on updates

## Testing Checklist

- [ ] Admin user created successfully
- [ ] Admin can login with correct credentials
- [ ] Admin sees only Profile and User Management in sidebar
- [ ] Admin can access `/admin` page
- [ ] Admin can view user details
- [ ] Admin can edit user information
- [ ] Admin can delete regular users
- [ ] Admin cannot delete other admin users
- [ ] Regular user cannot access `/admin` (403 error)
- [ ] Regular user sees Dashboard, Tasks, Calendar in sidebar
- [ ] Search functionality works
- [ ] Statistics display correctly

## Customization

### Change Admin Credentials

Edit `database/seeders/AdminUserSeeder.php`:

```php
User::create([
    'username' => 'your_username',
    'email' => 'your_email@example.com',
    'password' => Hash::make('your_password'),
    'first_name' => 'Your',
    'last_name' => 'Name',
    'role' => 'admin',
]);
```

Then run: `php artisan db:seed --class=AdminUserSeeder`

### Add More Roles

1. Update migration to add new role:
```php
$table->enum('role', ['user', 'admin', 'moderator'])->default('user');
```

2. Add role check method in User model:
```php
public function isModerator(): bool
{
    return $this->role === 'moderator';
}
```

3. Create middleware for new role
4. Update sidebar navigation in `layouts/app.blade.php`

## Troubleshooting

### Admin user not created
- Check database connection
- Run migrations: `php artisan migrate`
- Run seeder again: `php artisan db:seed --class=AdminUserSeeder`

### 403 Error when accessing admin page
- Verify you're logged in as admin
- Check role in database: `SELECT role FROM users WHERE email = 'admin@dailydo.com'`
- Clear cache: `php artisan cache:clear`

### Sidebar not showing correct items
- Clear view cache: `php artisan view:clear`
- Check `isAdmin()` method in User model
- Verify auth user: `auth()->user()->role`

### Cannot delete users
- Check CSRF token in requests
- Verify admin middleware is working
- Check browser console for JavaScript errors

## Additional Resources

- Laravel Authentication: https://laravel.com/docs/authentication
- Laravel Authorization: https://laravel.com/docs/authorization
- Middleware: https://laravel.com/docs/middleware

## Support

For issues or questions:
1. Check the test page: `/test-roles`
2. Review Laravel logs: `storage/logs/laravel.log`
3. Check browser console for JavaScript errors
4. Verify database structure matches migrations
