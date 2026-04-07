# 💧 Hydration Buddy

A beautiful web application to track your daily water intake and stay hydrated!

## Features

- **Loading Screen**: Welcome screen with "Hi welcome SEN" message
- **Interactive Dashboard**: Track your water intake with visual progress
- **One-Click Tracking**: Add a glass of water with a single click
- **Daily Goal**: 8 glasses per day (250ml each = 2000ml total)
- **Automatic Reset**: Resets every day at midnight (12:00 AM)
- **History Tracking**: View today's and yesterday's water intake
- **MySQL Database**: All records are saved and persistent

## Tech Stack

- **Backend**: Laravel 13 (PHP 8.3+)
- **Frontend**: Blade Templates, Vanilla JavaScript
- **Database**: MySQL
- **Styling**: Custom CSS with gradient theme

## Installation & Setup

### Prerequisites

- PHP 8.3 or higher
- Composer
- MySQL (via WAMP or standalone)
- Node.js and NPM

### Step 1: Create Database

1. Open phpMyAdmin (http://localhost/phpmyadmin)
2. Create a new database named `hydration_buddy`:
   - Click "New" in the left sidebar
   - Database name: `hydration_buddy`
   - Collation: `utf8mb4_unicode_ci`
   - Click "Create"

**OR** run the SQL script:
```sql
CREATE DATABASE IF NOT EXISTS hydration_buddy
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
```

### Step 2: Configure Environment

The `.env` file has been configured with:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hydration_buddy
DB_USERNAME=root
DB_PASSWORD=
```

If your MySQL credentials are different, update the `.env` file accordingly.

### Step 3: Install Dependencies

```bash
composer install
npm install
```

### Step 4: Run Migrations

```bash
php artisan migrate
```

This will create the `water_intake` table with the following structure:
- `id`: Primary key
- `user_identifier`: User identifier (default: 'default_user')
- `glasses_count`: Number of glasses consumed
- `intake_date`: Date of intake
- `created_at`, `updated_at`: Timestamps

### Step 5: Build Assets

```bash
npm run build
```

### Step 6: Start the Server

```bash
php artisan serve
```

The application will be available at: **http://127.0.0.1:8000**

## Usage

1. **Access the Application**: Open http://127.0.0.1:8000 in your browser
2. **Loading Screen**: You'll see the welcome message "Hi welcome SEN" for 3 seconds
3. **Dashboard**: You'll be automatically redirected to the dashboard
4. **Track Water**: Click the "➕ Add Glass" button each time you drink a glass of water
5. **Monitor Progress**: 
   - View your glass count (0-8 glasses)
   - See total ml consumed (0-2000ml)
   - Check progress bar percentage
   - Visual glass icons show filled glasses
6. **View History**: See today's and yesterday's intake at the bottom
7. **Daily Reset**: The counter automatically resets at midnight

## Application Structure

### Routes (`routes/web.php`)
- `GET /` - Loading screen
- `GET /dashboard` - Main dashboard
- `POST /api/add-glass` - Add a glass (AJAX)
- `GET /api/today` - Get today's data (AJAX)
- `GET /api/yesterday` - Get yesterday's data (AJAX)

### Controller (`app/Http/Controllers/HydrationController.php`)
Handles all application logic:
- Loading screen display
- Dashboard data retrieval
- Adding glasses
- Fetching today/yesterday data

### Model (`app/Models/WaterIntake.php`)
Eloquent model with helper methods:
- `getTodayRecord()` - Get or create today's record
- `getYesterdayRecord()` - Get yesterday's record
- `addGlass()` - Increment glass count

### Views
- `resources/views/welcome-loading.blade.php` - Loading screen
- `resources/views/dashboard.blade.php` - Main dashboard

### Database
- Table: `water_intake`
- Migration: `database/migrations/2024_01_01_000000_create_water_intake_table.php`

## Features Explained

### Automatic Midnight Reset
The application uses Laravel's date handling to automatically show the correct day's data. When you access the dashboard:
- It fetches or creates today's record based on the current date
- If it's a new day, a new record is created with 0 glasses
- Previous day's data is preserved in the database

### Progress Tracking
- Visual progress bar shows percentage (0-100%)
- Glass icons (8 total) fill up as you drink
- ml counter shows milliliters consumed
- Achievement message appears when you reach 8 glasses

### History Display
- **Today**: Shows current day's intake with live updates
- **Yesterday**: Shows previous day's intake from database
- Dates are formatted in a readable format (e.g., "Apr 07, 2026")

## Customization

### Change Daily Goal
Edit in `dashboard.blade.php`:
- Change `8` to your desired glass count
- Update `2000` (ml) accordingly
- Adjust the visual glass icons loop

### Change Glass Volume
Edit in the controller and views:
- Default: 250ml per glass
- Update calculations in `dashboard.blade.php`

### Styling
All styles are in the `<style>` sections of:
- `welcome-loading.blade.php` - Loading screen colors/animations
- `dashboard.blade.php` - Dashboard theme

## Troubleshooting

### Database Connection Error
- Ensure WAMP is running
- Verify MySQL service is active
- Check credentials in `.env` file
- Test connection in phpMyAdmin

### Migration Fails
- Make sure database `hydration_buddy` exists
- Check MySQL user has proper permissions
- Run: `php artisan config:clear`

### Page Not Loading
- Ensure server is running: `php artisan serve`
- Check port 8000 is not in use
- Clear browser cache

## Future Enhancements

Potential features to add:
- User authentication for multiple users
- Weekly/monthly statistics
- Reminders/notifications
- Custom goals per user
- Dark mode
- Mobile app version

## License

Open source - feel free to modify and use!

---

**Stay Hydrated! 💧**
