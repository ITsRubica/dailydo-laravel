# Admin System - Quick Reference Card

## 🚀 Quick Setup (3 Steps)

```bash
# 1. Run migrations (if not done)
php artisan migrate

# 2. Create admin user
php artisan db:seed --class=AdminUserSeeder

# 3. Test the system
# Visit: http://localhost:8000/test-roles
```

## 🔐 Default Credentials

```
Email:    admin@dailydo.com
Password: admin123
```

## 📍 Important URLs

| URL | Access | Description |
|-----|--------|-------------|
| `/login` | Public | Login page |
| `/register` | Public | Registration page |
| `/admin` | Admin only | User Management |
| `/dashboard` | Users only | Dashboard |
| `/profile` | All authenticated | Profile page |
| `/test-roles` | All authenticated | System test page |

## 👥 User Roles

### Admin Role
- ✅ Profile
- ✅ User Management
- ❌ Dashboard
- ❌ Tasks
- ❌ Calendar

### User Role
- ✅ Profile
- ✅ Dashboard
- ✅ Tasks
- ✅ Calendar
- ❌ User Management

## 🎯 Admin Features

| Feature | Description |
|---------|-------------|
| View Users | See all registered users |
| Search | Filter by name or email |
| View Details | Click user card to see info |
| Edit User | Update username and email |
| Delete User | Remove user and their tasks |
| Statistics | Total, Active, New users |

## 🔒 Security Rules

1. ✅ Admin routes protected by middleware
2. ✅ Cannot delete admin users
3. ✅ CSRF protection on all forms
4. ✅ Email validation on updates
5. ✅ 403 error for unauthorized access

## 📁 Key Files

```
Database:
└── database/seeders/AdminUserSeeder.php

Controllers:
└── app/Http/Controllers/AdminController.php

Middleware:
└── app/Http/Middleware/AdminMiddleware.php

Views:
├── resources/views/admin/dashboard.blade.php
├── resources/views/test-roles.blade.php
└── resources/views/layouts/app.blade.php

Routes:
└── routes/web.php
```

## 🧪 Testing Checklist

### Admin Tests
- [ ] Login as admin
- [ ] See User Management in sidebar
- [ ] Access /admin page
- [ ] View user list
- [ ] Search users
- [ ] Edit user
- [ ] Delete user
- [ ] Cannot delete admin

### User Tests
- [ ] Register new user
- [ ] Login as user
- [ ] See Dashboard in sidebar
- [ ] Cannot access /admin (403)
- [ ] Can access /dashboard

## 🛠️ Common Commands

```bash
# Create admin user
php artisan db:seed --class=AdminUserSeeder

# Clear cache
php artisan cache:clear
php artisan view:clear
php artisan config:clear

# Check user role
php artisan tinker
>>> User::where('email', 'admin@dailydo.com')->first()->role

# View all admin users
php artisan tinker
>>> User::where('role', 'admin')->get()
```

## 🐛 Quick Troubleshooting

| Problem | Solution |
|---------|----------|
| Admin not created | Run seeder again |
| 403 on /admin | Check user role in database |
| Sidebar wrong | Clear view cache |
| Can't delete user | Check browser console |
| Login fails | Verify credentials |

## 📊 API Endpoints

```
GET    /admin              # User management page
PUT    /admin/users/{id}   # Update user
DELETE /admin/users/{id}   # Delete user
```

## 💡 Quick Tips

1. **Test First**: Visit `/test-roles` to verify setup
2. **Change Password**: Update admin password in production
3. **Clear Cache**: Run cache:clear after changes
4. **Check Logs**: Review `storage/logs/laravel.log`
5. **Browser Console**: Check for JavaScript errors

## 📞 Need Help?

1. Check `/test-roles` page
2. Review `ADMIN_COMPLETE_GUIDE.md`
3. Check Laravel logs
4. Verify database structure
5. Clear all caches

## 🎉 Success Indicators

✅ Admin user exists in database
✅ Can login with admin credentials
✅ Sidebar shows correct items
✅ Can access /admin page
✅ Can manage users
✅ Regular users get 403 on /admin
✅ Test page shows all green checks

---

**Ready to start?** Run: `php artisan db:seed --class=AdminUserSeeder`
