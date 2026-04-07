@echo off
echo ====================================
echo   Hydration Buddy - Setup Script
echo ====================================
echo.

echo Step 1: Creating Database...
echo Please ensure WAMP/MySQL is running!
echo.
echo Open phpMyAdmin (http://localhost/phpmyadmin) and create database 'hydration_buddy'
echo OR run: database\create_database.sql
echo.
pause

echo.
echo Step 2: Installing Composer Dependencies...
call composer install
echo.

echo Step 3: Running Migrations...
call php artisan migrate
echo.

echo Step 4: Installing NPM Dependencies...
call npm install
echo.

echo Step 5: Building Assets...
call npm run build
echo.

echo ====================================
echo   Setup Complete!
echo ====================================
echo.
echo To start the application:
echo   php artisan serve
echo.
echo Then open: http://127.0.0.1:8000
echo.
pause
