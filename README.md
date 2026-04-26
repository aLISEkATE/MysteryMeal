# MysteryMeal

A Laravel-based recipe discovery and minigame application with a pastel pink and blue aesthetic.

## Features

- Browse recipes by category and cuisine
- Interactive minigame for engagement
- User authentication and profiles
- Favorite recipes tracking
- Score and time tracking for minigames

## Prerequisites

- PHP 8.5+
- Node.js 18+
- npm or yarn
- MySQL 8.0+
- Composer

## Installation

### 1. Clone the repository

```bash
git clone <repository-url>
cd MysteryMeal
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install Node.js dependencies

```bash
npm install
```

### 4. Set up environment file

```bash
cp .env.example .env
```

Edit the `.env` file and configure your database credentials:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mysterymeal
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Generate application key

```bash
php artisan key:generate
```

### 6. Create database

Create a MySQL database named `mysterymeal`:

```sql
CREATE DATABASE mysterymeal;
```

### 7. Run migrations

```bash
php artisan migrate
```

### 8. Seed the database (optional)

```bash
php artisan db:seed
```

This will populate the database with sample meal data.

## Running the Project

### Start the development server

In one terminal, start the Laravel server:

```bash
php artisan serve
```

The application will be available at `http://127.0.0.1:8000`

### Start the Vite development server (in another terminal)

```bash
npm run dev
```

This will build and watch your CSS and JavaScript files.

### For production build

```bash
npm run build
```

## Project Structure

- `app/Models/` - Database models (Meal, User, Score, etc.)
- `app/Http/Controllers/` - Application controllers
- `resources/views/` - Blade template files
- `resources/js/` - JavaScript files including minigame logic
- `resources/css/` - Stylesheet files
- `database/migrations/` - Database migration files
- `database/seeders/` - Database seeder files
- `routes/` - Application routes

## Key Features

### Recipes
- View all available recipes
- Filter by category and area
- Detailed recipe view with ingredients and instructions

### Minigame
- Catch falling ingredients
- Avoid bad items
- Track score and time
- Increasing difficulty as the game progresses

### User System
- User registration and login
- Profile management
- Favorite recipes tracking

## Testing

To run tests:

```bash
php artisan test
```

## Troubleshooting

### Vite build errors

If you encounter import resolution errors:

```bash
npm install
npm run dev
```

### Database connection errors

Ensure your MySQL server is running and your `.env` database credentials are correct.

### Permission errors

Make sure the `storage/` and `bootstrap/cache/` directories are writable:

```bash
chmod -R 775 storage bootstrap/cache
```

## Development Notes

- The minigame has a speed limit to ensure items remain visible
- Images are fetched from external sources
- The application uses Laravel Breeze for authentication

## License

This project is open source and available under the MIT License.
