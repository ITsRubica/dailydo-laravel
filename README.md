# DailyDo - Task Management Application

A simple and efficient task management application built with Laravel.

## Features

- User authentication (Register/Login)
- Task management (Create, Read, Update, Delete)
- Task priorities (Low, Medium, High)
- Task deadlines with reminders
- Dashboard with task statistics
- Responsive design with sidebar navigation

## Project Structure

```
dailydo-laravel/
├── app/                    # Application core
│   ├── Http/Controllers/  # Request handlers
│   ├── Models/            # Database models
│   └── Providers/         # Service providers
├── database/              # Database files
│   ├── factories/         # Model factories for testing
│   ├── migrations/        # Database schema
│   └── seeders/           # Sample data
├── docs/                  # Project documentation
├── public/                # Public assets (compiled)
│   ├── css/              # Compiled stylesheets
│   └── js/               # Compiled scripts
├── resources/             # Raw assets and views
│   ├── css/              # Source CSS files
│   ├── js/               # Source JavaScript
│   └── views/            # Blade templates
├── routes/                # Application routes
├── tests/                 # Automated tests
│   ├── Feature/          # Feature tests
│   └── Unit/             # Unit tests
└── vendor/                # Composer dependencies
```

## Installation

1. Clone the repository
2. Install dependencies:
   ```bash
   composer install
   ```
3. Copy `.env.example` to `.env` and configure your database
4. Generate application key:
   ```bash
   php artisan key:generate
   ```
5. Run migrations:
   ```bash
   php artisan migrate
   ```
6. Start the development server:
   ```bash
   php artisan serve
   ```

## Development

- **CSS**: Edit files in `resources/css/app.css`, then copy to `public/css/`
- **Views**: Edit Blade templates in `resources/views/`
- **Routes**: Define in `routes/web.php`
- **Controllers**: Create in `app/Http/Controllers/`

## Testing

Run tests:
```bash
php artisan test
```

## License

This project is open-sourced software.
