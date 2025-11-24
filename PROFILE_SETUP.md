# Profile Page Setup Guide

## Required Setup Steps

### 1. Run Database Migration
Run the new migration to add the `current_streak` column to the users table:

```bash
php artisan migrate
```

### 2. Create Storage Symlink
The profile picture upload feature requires a symbolic link from `public/storage` to `storage/app/public`:

```bash
php artisan storage:link
```

This command creates a symbolic link that makes files in `storage/app/public` accessible via the web.

### 3. Ensure Storage Directory Exists
Make sure the profile_pictures directory exists:

```bash
mkdir -p storage/app/public/profile_pictures
```

### 4. Set Proper Permissions (Linux/Mac)
If on Linux or Mac, ensure proper permissions:

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

## Features Now Working

### ✅ Profile Picture Upload
- Users can upload profile pictures (JPEG, PNG, JPG, GIF)
- Maximum file size: 2MB
- Old pictures are automatically deleted when uploading new ones
- Pictures are stored in `storage/app/public/profile_pictures`
- Accessible via `storage/profile_pictures/filename.jpg`

### ✅ Profile Information Update
- First Name
- Last Name
- Email Address
- Bio
- Interests (comma-separated)

### ✅ Password Management
- Requires current password verification
- Minimum 8 characters
- Password confirmation required

### ✅ User Streak Display
- Shows current streak count
- Defaults to 0 if not set

## How It Works

### Profile Picture Upload
1. User clicks "Update Picture" button
2. Selects an image file
3. Form automatically submits via JavaScript
4. Controller validates the file (type, size)
5. Old picture is deleted (if exists)
6. New picture is stored in `storage/app/public/profile_pictures`
7. Database is updated with the file path
8. User is redirected back with success message

### Form Sections
Each section (Bio, Profile Info, Password) has:
- Display mode (read-only view)
- Edit mode (form with inputs)
- Toggle button to switch between modes
- Save and Cancel buttons in edit mode

## Troubleshooting

### Profile Picture Not Displaying
1. Verify storage link exists: `ls -la public/storage`
2. Check file exists: `ls -la storage/app/public/profile_pictures`
3. Verify APP_URL in `.env` matches your local URL
4. Clear cache: `php artisan cache:clear`

### Upload Fails
1. Check file size (must be < 2MB)
2. Check file type (JPEG, PNG, JPG, GIF only)
3. Verify storage directory permissions
4. Check PHP upload limits in `php.ini`:
   - `upload_max_filesize = 2M`
   - `post_max_size = 2M`

### Validation Errors
- Forms now use 'sometimes' validation for optional updates
- Only fields that are submitted will be validated and updated
- Password update requires current password verification

## Technical Details

### Controller Changes
- Updated validation to use 'sometimes' for optional fields
- Removed username requirement (not in form)
- Conditional updates based on filled fields
- Proper file handling with Storage facade

### Database Schema
- `profile_picture` column: nullable string
- `current_streak` column: integer, default 0
- All profile fields are nullable except required ones

### Security
- File type validation (images only)
- File size limit (2MB)
- Old files are deleted to prevent storage bloat
- Password verification required for password changes
- CSRF protection on all forms
