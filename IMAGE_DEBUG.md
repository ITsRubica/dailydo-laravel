# Profile Picture Debug Guide

## Current Issue
Image uploads successfully but doesn't display after page reload.

## What Was Fixed

1. **Success notification** - Now smaller and positioned below the Profile header
2. **Cache busting** - Added `?v={{ time() }}` to force browser to reload image
3. **Moved alert** - Removed from layout, added to profile page only

## Critical Setup Step

**YOU MUST RUN THIS COMMAND:**
```bash
php artisan storage:link
```

Without this, images will NEVER display even though they upload successfully.

## How to Verify Storage Link

### Windows:
```cmd
dir public\storage
```

### Linux/Mac:
```bash
ls -la public/storage
```

You should see a symbolic link pointing to `storage/app/public`

## Debug Steps

### 1. Check if image was uploaded
Look in: `storage/app/public/profile_pictures/`
- If files are there, upload is working
- If not, check permissions

### 2. Check database
Run in your database:
```sql
SELECT id, first_name, last_name, profile_picture FROM users WHERE id = YOUR_USER_ID;
```

The `profile_picture` column should contain something like:
- `profile_pictures/abc123.jpg`

### 3. Check if storage link exists
```bash
# Windows
dir public\storage

# Linux/Mac  
ls -la public/storage
```

If you get "file not found" or "no such file", run:
```bash
php artisan storage:link
```

### 4. Test direct URL access
After uploading, try accessing directly in browser:
```
http://localhost:8000/storage/profile_pictures/FILENAME.jpg
```

Replace FILENAME with the actual filename from the database.

- **If 404**: Storage link is missing or broken
- **If image shows**: Problem is in the Blade template
- **If permission denied**: File permissions issue

### 5. Check browser console
Press F12 and look for errors like:
- `404 Not Found` - Storage link missing
- `403 Forbidden` - Permission issue
- `ERR_FILE_NOT_FOUND` - Path is wrong

## Common Issues & Solutions

### Issue: 404 on image URL
**Solution:**
```bash
php artisan storage:link
```

### Issue: Storage link already exists but still 404
**Solution:**
```bash
# Remove old link
# Windows:
rmdir public\storage
# Linux/Mac:
rm public/storage

# Recreate it
php artisan storage:link
```

### Issue: Permission denied
**Solution (Linux/Mac):**
```bash
sudo chown -R www-data:www-data storage
sudo chmod -R 775 storage
```

### Issue: Image path in database is wrong
**Solution:**
Check what's actually saved in the database. It should be:
- ✅ `profile_pictures/filename.jpg`
- ❌ `public/profile_pictures/filename.jpg`
- ❌ `/storage/profile_pictures/filename.jpg`

## Expected Behavior After Fix

1. Click "Update Picture"
2. Select image
3. Image shows immediately (preview)
4. Page reloads
5. Image still shows (from server)
6. Small success message appears below Profile header
7. Only ONE success message (not two)

## File Paths Explained

```
Upload: User selects image
   ↓
Store: storage/app/public/profile_pictures/abc123.jpg
   ↓
Database: profile_pictures/abc123.jpg
   ↓
Symlink: public/storage → storage/app/public
   ↓
URL: http://localhost:8000/storage/profile_pictures/abc123.jpg
   ↓
Blade: {{ asset('storage/' . $user->profile_picture) }}
   ↓
Output: http://localhost:8000/storage/profile_pictures/abc123.jpg
```

## Quick Test

1. Run: `php artisan storage:link`
2. Upload a test image
3. Check database for the path
4. Try accessing: `http://localhost:8000/storage/[path-from-database]`
5. If step 4 works, the issue is in the Blade template
6. If step 4 fails, the storage link is broken

## Still Not Working?

Add this temporarily to your profile view to debug:

```blade
<!-- DEBUG INFO - Remove after fixing -->
<div class="alert alert-info">
    <strong>Debug Info:</strong><br>
    Profile Picture Path: {{ $user->profile_picture ?? 'NULL' }}<br>
    Full URL: {{ asset('storage/' . $user->profile_picture) }}<br>
    File Exists: {{ $user->profile_picture && file_exists(storage_path('app/public/' . $user->profile_picture)) ? 'YES' : 'NO' }}
</div>
```

This will show you exactly what's happening.
