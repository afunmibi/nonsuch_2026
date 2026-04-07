# Nonsuch (2026)

A Laravel-based medical claims / vetting application used for development and testing.

**Quick summary**: this repository is a Laravel app. Use XAMPP or another local LAMP stack, set the database in `./.env`, install dependencies, then run migrations and seeders.

**Status**: Development

---

**Prerequisites**
- **PHP** 8.x (as required by the installed Laravel version)
- **Composer**
- **Node.js** + **npm** (for frontend assets)
- **MySQL** (or MariaDB) — commonly provided by XAMPP on Windows

**Repository layout (important files)**
- `app/` — Laravel application code
- `database/seeders/DatabaseSeeder.php` — seeds default data (includes an admin seed)
- `database/factories/UserFactory.php` — user factory used by seeders
- `routes/web.php` — web routes
- `public/` — web entry (served by local server)

---

**Setup (local development)**

1. Clone repository and change directory:

```powershell
cd C:\path\to\projects
git clone <repo-url>
cd nonsuch_2026
```

2. Install PHP dependencies:

```powershell
composer install
```

3. Install Node dependencies and build assets (dev):

```powershell
npm install
npm run dev
```

4. Copy the environment file and generate an app key:

```powershell
copy .env.example .env
php artisan key:generate
```

5. Configure database credentials in `./.env` (e.g. `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).

6. Run migrations and seeders (seed will create a test user and an admin user):

```powershell
php artisan migrate --force
php artisan db:seed --class=DatabaseSeeder
```

Notes:
- If you want a completely fresh database (destroys all data) use:

```powershell
php artisan migrate:fresh --seed
```

---



The seeder that creates/updates this account is `database/seeders/DatabaseSeeder.php`. Change or remove this code as appropriate for production.

To change the admin password quickly (using PowerShell):

```powershell
php artisan tinker
use App\Models\User; use Illuminate\Support\Facades\Hash;
$user = User::where('email', 'afunmibi@gmail.com')->first();
$user->password = Hash::make('YourNewStrongPassword'); $user->save(); exit
```

---

**Testing**

Run the project's test suite with PHPUnit:

```powershell
./vendor/bin/phpunit
```

---

**Troubleshooting**
- Duplicate email error when seeding: make the user creation idempotent (the included seeder uses `updateOrCreate`/`update`) or remove existing conflicting users before running the seed.
- If mail or queue features fail, check `MAIL_` and `QUEUE_` variables in `./.env`.

---

**Security & deployment notes**
- DO NOT ship the seeded admin password to production. Remove or protect the admin seed and rotate passwords before deployment.
- Use environment variables for production secrets and a secure storage mechanism for any generated credentials.

---

If you want, I can:
- Remove the persistent admin creation from `database/seeders/DatabaseSeeder.php`.
- Add a command to generate a strong admin password and print it to the console.
- Create a CONTRIBUTING.md with development workflow guidelines.

---

Maintainers: repository owner
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
