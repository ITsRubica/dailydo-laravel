@echo off
echo ========================================
echo DailyDo Admin Setup Script
echo ========================================
echo.

echo Step 1: Running migrations...
php artisan migrate
echo.

echo Step 2: Creating admin user...
php artisan db:seed --class=AdminUserSeeder
echo.

echo Step 3: Clearing cache...
php artisan cache:clear
php artisan view:clear
php artisan config:clear
echo.

echo ========================================
echo Setup Complete!
echo ========================================
echo.
echo Admin credentials:
echo   Email: admin@dailydo.com
echo   Password: admin123
echo.
echo Test the system:
echo   1. Visit: http://localhost:8000/test-roles
echo   2. Login at: http://localhost:8000/login
echo   3. Access admin panel: http://localhost:8000/admin
echo.
echo Press any key to exit...
pause > nul
