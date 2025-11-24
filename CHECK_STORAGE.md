# Storage Setup Verification

## Issue: Profile Picture Not Showing

The profile picture upload saves the file but doesn't display. This is typically caused by:

1. **Missing storage symlink** - The most common issue
2. **Incorrect file path in database**
3. **Permission issues**

## Quick Fix Commands

Run these commands in order:

```bash
# 1. Create the storage symlink (REQUIRED)
php artisan storage:link

# 2. Verify the symlink was created
# On Windows:
dir public\storage
# On Linux/Mac:
ls -la public/storage

# 3. Create the profile_pictures directory if it doesn't exist
# On Windows:
mkdir storage\app\public\profile_pictures
# On Linux/Mac:
mkdir -p storage/app/public/profile_pictures

# 4. Set permissions (Linux/Mac only)
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

## How to Verify It's Working

1. After running `php artisan storage:link`, you should see:
   - `The [public/storage] link has been connected to [storage/app/public]`
   - OR `The [public/storage] link already exists`

2. Check if the symlink exists:
   - Navigate to `public/storage` - it should exist
   - It should point to `storage/app/public`

3. Upload a test image:
   - Go to profile page
   - Click "Update Picture"
   - Select an image
   - The image should display immediately

## What Was Fixed

1. **Removed duplicate success notification** - Was showing in both layout and profile view
2. **Added instant preview** - Image shows immediately after selection (before upload completes)
3. **Fixed image display** - Added proper IDs for JavaScript to update the image
4. **Improved upload flow** - Better user experience with instant feedback

## File Storage Path

When you upload a profile picture:
- File is stored in: `storage/app/public/profile_pictures/filename.jpg`
- Database stores: `profile_pictures/filename.jpg`
- Accessed via: `http://localhost:8000/storage/profile_pictures/filename.jpg`
- In Blade: `{{ asset('storage/' . $user->profile_picture) }}`

## Troubleshooting

### Image still not showing?

1. **Check browser console** (F12) for 404 errors
2. **Verify symlink exists**: `ls -la public/storage` (should show link to storage/app/public)
3. **Check file was uploaded**: Look in `storage/app/public/profile_pictures/`
4. **Clear cache**: `php artisan cache:clear` and `php artisan config:clear`
5. **Check APP_URL** in `.env` matches your local URL

### Permission denied errors?

On Linux/Mac:
```bash
sudo chown -R www-data:www-data storage
sudo chmod -R 775 storage
```

On Windows, ensure your user has write permissions to the storage folder.
