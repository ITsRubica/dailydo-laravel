# DailyDo Admin System

Complete role-based access control system for DailyDo Laravel application.

## 🚀 Quick Start

### Windows Users
Simply run the setup script:
```bash
setup-admin.bat
```

### Manual Setup
```bash
# Run migrations
php artisan migrate

# Create admin user
php artisan db:seed --class=AdminUserSeeder

# Clear cache
php artisan cache:clear
php artisan view:clear
```

## 🔐 Default Admin Credentials

```
Email: admin@dailydo.com
Password: admin123
```

**⚠️ Important**: Change these credentials in production!

## 📋 Features

### Admin Role
- ✅ Access to User Management dashboard
- ✅ View all registered users
- ✅ Edit user information (username, email)
- ✅ Delete users (except other admins)
- ✅ View user statistics
- ✅ Search and filter users
- ✅ Access to Profile page
- ❌ No access to Dashboard, Tasks, or Calendar

### User Role
- ✅ Access to Dashboard
- ✅ Access to Task List
- ✅ Access to Calendar
- ✅ Access to Profile page
- ❌ No access to User Management (403 error)

## 🧪 Testing

### Test Page
Visit `/test-roles` to verify:
- Admin users exist in database
- Regular users exist in database
- Authentication functions work
- Current session status
- Route access permissions
- Database statistics

### Manual Testing

1. **Test Admin Access**:
   ```
   1. Login as admin@dailydo.com
   2. Check sidebar shows: Profile, User Management
   3. Access /admin - should work
   4. Try to access /dashboard - should redirect or show error
   ```

2. **Test User Access**:
   ```
   1. Register new user account
   2. Check sidebar shows: Profile, Dashboard, Tasks, Calendar
   3. Try to access /admin - should show 403 error
   4. Access /dashboard - should work
   ```

## 📁 File Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   └── AdminController.php          # Admin panel logic
│   └── Middleware/
│       └── AdminMiddleware.php          # Admin access control
├── Models/
│   └── User.php                         # User model with isAdmin()
database/
├── migrations/
│   └── 2024_01_14_000000_create_users_table.php  # Users table with role
└── seeders/
    └── AdminUserSeeder.php              # Admin user seeder
resources/
└── views/
    ├── admin/
    │   └── dashboard.blade.php          # User management page
    ├── layouts/
    │   └── app.blade.php                # Layout with role-based sidebar
    └── test-roles.blade.php             # Testing page
routes/
└── web.php                              # Routes with admin middleware
```

## 🎯 User Management Features

### Dashboard Statistics
- Total Users count
- Active Users (users with tasks in last 7 days)
- New Users this month

### User List
- Display all users with avatar, name, email
- Registration date
- Role badge (Admin/User)
- Click to view details

### User Details Modal
- View Mode:
  - Full user information
  - Avatar with initials
  - Registration date
  - Role badge
  
- Edit Mode:
  - Update username
  - Update email
  - Email validation
  - Cannot edit role (security)
  - Delete user option

### Search & Filter
- Real-time search by name or email
- Refresh button to reload data

## 🔒 Security Features

1. **Middleware Protection**: All admin routes protected
2. **Role Verification**: Database-level role checking
3. **Delete Protection**: Cannot delete admin users
4. **CSRF Protection**: All forms include CSRF tokens
5. **Input Validation**: Server-side validation
6. **403 Errors**: Proper error handling for unauthorized access

## 🛠️ API Endpoints

### Admin Routes (Requires admin role)

```php
GET    /admin                    # User management dashboard
GET    /admin/users              # List users (with pagination)
GET    /admin/tasks              # List all tasks
PUT    /admin/users/{user}       # Update user
DELETE /admin/users/{user}       # Delete user
```

### Response Format

**Success Response**:
```json
{
    "success": true,
    "message": "User updated successfully.",
    "user": { ... }
}
```

**Error Response**:
```json
{
    "success": false,
    "message": "Cannot delete admin users."
}
```

## 🎨 UI Components

### User Card
- Avatar with initials
- Full name
- Email address
- Registration date
- Role badge
- Hover effect
- Click to view details

### Statistics Cards
- Gradient background
- Icon representation
- Large number display
- Descriptive label

### Modal
- View/Edit mode toggle
- Form validation
- Confirmation dialogs
- Smooth animations

## 📝 Customization

### Change Admin Credentials

Edit `database/seeders/AdminUserSeeder.php`:

```php
User::create([
    'username' => 'your_admin',
    'email' => 'your_email@example.com',
    'password' => Hash::make('your_secure_password'),
    'first_name' => 'Your',
    'last_name' => 'Name',
    'role' => 'admin',
]);
```

Run: `php artisan db:seed --class=AdminUserSeeder`

### Add Additional Admin Users

Create a new seeder or add to existing:

```php
User::create([
    'username' => 'admin2',
    'email' => 'admin2@dailydo.com',
    'password' => Hash::make('password'),
    'first_name' => 'Second',
    'last_name' => 'Admin',
    'role' => 'admin',
]);
```

### Customize Sidebar Navigation

Edit `resources/views/layouts/app.blade.php`:

```blade
@if(auth()->user()->isAdmin())
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-people me-2"></i>
            User Management
        </a>
    </li>
    <!-- Add more admin menu items here -->
@endif
```

## 🐛 Troubleshooting

### Issue: Admin user not created
**Solution**:
```bash
# Check database connection
php artisan migrate:status

# Run migrations if needed
php artisan migrate

# Run seeder
php artisan db:seed --class=AdminUserSeeder
```

### Issue: 403 Error when accessing /admin
**Solution**:
```bash
# Verify role in database
php artisan tinker
>>> User::where('email', 'admin@dailydo.com')->first()->role

# Should return: "admin"

# Clear cache
php artisan cache:clear
php artisan config:clear
```

### Issue: Sidebar not updating
**Solution**:
```bash
# Clear view cache
php artisan view:clear

# Check if user is authenticated
php artisan tinker
>>> auth()->check()
>>> auth()->user()->isAdmin()
```

### Issue: Cannot delete users
**Solution**:
- Check browser console for JavaScript errors
- Verify CSRF token is present
- Check network tab for API response
- Review `storage/logs/laravel.log`

### Issue: Search not working
**Solution**:
- Clear browser cache
- Check JavaScript console for errors
- Verify Bootstrap JS is loaded
- Test with browser dev tools

## 📊 Database Schema

### Users Table
```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) UNIQUE,
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    bio TEXT,
    interests TEXT,
    profile_picture VARCHAR(255),
    role ENUM('user', 'admin') DEFAULT 'user',
    current_streak INT DEFAULT 0,
    remember_token VARCHAR(100),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

## 🔄 Workflow

### Admin Login Flow
```
1. User visits /login
2. Enters admin credentials
3. AuthController validates credentials
4. Checks user role
5. If admin: Redirect to /admin
6. If user: Redirect to /dashboard
```

### User Management Flow
```
1. Admin accesses /admin
2. AdminMiddleware checks role
3. AdminController loads users
4. View displays user list
5. Admin clicks user card
6. Modal shows user details
7. Admin can edit or delete
8. AJAX request to API
9. Database updated
10. Page refreshed
```

## 📚 Additional Documentation

- [Full Setup Guide](ADMIN_ROLE_SETUP.md)
- [Implementation Details](ADMIN_IMPLEMENTATION.md)
- [Quick Start Guide](QUICK_START_ADMIN.md)

## 🤝 Contributing

When adding new features:
1. Update role checks in middleware
2. Update sidebar navigation
3. Add tests for new routes
4. Update documentation
5. Test with both admin and user roles

## 📄 License

This admin system is part of the DailyDo Laravel application.

---

**Need Help?** Check `/test-roles` page for system diagnostics.
