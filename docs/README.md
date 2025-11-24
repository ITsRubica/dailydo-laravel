# DailyDo Documentation

This folder contains project documentation and reference materials.

## Files

- `reference.md` - PHP version reference for design and functionality

## Project Structure

```
dailydo-laravel/
├── app/                    # Application core
│   ├── Console/           # Artisan commands
│   ├── Exceptions/        # Exception handlers
│   ├── Http/              # Controllers, Middleware, Requests
│   ├── Models/            # Eloquent models
│   └── Providers/         # Service providers
├── bootstrap/             # Framework bootstrap
├── config/                # Configuration files
├── database/              # Database files
│   ├── factories/         # Model factories
│   ├── migrations/        # Database migrations
│   └── seeders/           # Database seeders
├── docs/                  # Project documentation
├── public/                # Public assets
│   ├── css/              # Compiled CSS
│   └── js/               # Compiled JavaScript
├── resources/             # Raw assets
│   ├── css/              # Source CSS files
│   ├── js/               # Source JavaScript files
│   └── views/            # Blade templates
├── routes/                # Route definitions
├── storage/               # Generated files
├── tests/                 # Automated tests
│   ├── Feature/          # Feature tests
│   └── Unit/             # Unit tests
└── vendor/                # Composer dependencies
```

## Development Workflow

1. **CSS Changes**: Edit files in `resources/css/`
2. **JavaScript Changes**: Edit files in `resources/js/`
3. **Views**: Edit Blade templates in `resources/views/`
4. **Models**: Create/edit in `app/Models/`
5. **Controllers**: Create/edit in `app/Http/Controllers/`
6. **Routes**: Define in `routes/web.php` or `routes/api.php`

## Testing

Run tests with:
```bash
php artisan test
```

## Database

Run migrations:
```bash
php artisan migrate
```

Seed database:
```bash
php artisan db:seed
```
