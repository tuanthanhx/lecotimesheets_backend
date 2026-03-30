# PHP Hosting Deployment Guide

This project is a Laravel 11 backend with JWT authentication.

These instructions are for typical PHP hosting or shared hosting where you have:
- PHP 8.2+ available
- MySQL or MariaDB database
- File Manager, FTP, or SSH access
- A way to point the domain or subdomain to the `public` folder

## 1. Server Requirements

Minimum:
- PHP `8.2` or newer
- MySQL or MariaDB
- Composer support on the server, or the ability to upload the `vendor` folder

Recommended PHP extensions:
- `bcmath`
- `ctype`
- `fileinfo`
- `json`
- `mbstring`
- `openssl`
- `pdo`
- `pdo_mysql`
- `tokenizer`
- `xml`

## 2. Prepare the Project

Before uploading, make sure these exist locally:
- `vendor/`
- `.env`
- `storage/`
- `bootstrap/cache/`

If the hosting server does not support Composer, run this locally first:

```bash
composer install --no-dev --optimize-autoloader
```

Then upload the whole project including `vendor`.

If the server supports Composer, upload the project and run:

```bash
composer install --no-dev --optimize-autoloader
```

## 3. Upload the Project

Upload the project to a folder such as:

```text
/home/your-account/lecotimesheets_backend
```

Do not expose the whole project as the web root.

Your web root should point to:

```text
/home/your-account/lecotimesheets_backend/public
```

If your hosting panel cannot point the domain directly to `public`, you have 2 options:

1. Create a subdomain and set its document root to the `public` folder.
2. Move only the contents of `public/` into `public_html/` and update `index.php` paths carefully.

The first option is better.

## 4. Configure `.env`

Set the production values in `.env`.

Example:

```env
APP_NAME="leco_timesheets_backend"
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY
APP_DEBUG=false
APP_URL=https://api.your-domain.com

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

CACHE_STORE=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file

JWT_SECRET=your_long_random_secret_at_least_32_characters
JWT_ALGO=HS256
```

Important:
- `APP_DEBUG=false` in production
- `JWT_SECRET` must be set and should be long and random
- `JWT_ALGO=HS256`
- On shared hosting, `CACHE_STORE=file` and `SESSION_DRIVER=file` are safer than database-backed cache/session unless you already created those tables and want them

## 5. Generate App Key

If `APP_KEY` is empty, generate it:

```bash
php artisan key:generate
```

If needed, generate a JWT secret:

```bash
php artisan jwt:secret
```

If that command is not available on the hosting server, set `JWT_SECRET` manually in `.env`.

## 6. Create Database

Create a MySQL or MariaDB database from the hosting panel, then set the credentials in `.env`.

After that run:

```bash
php artisan migrate --force
```

If you want sample data too:

```bash
php artisan db:seed --force
```

Warning:
- Seeding adds demo users, jobs, and timesheets.
- Do not run the seeder on a live production database unless you want demo data.

## 7. Set Permissions

Laravel needs write access to:
- `storage/`
- `bootstrap/cache/`

Typical permission setup:

```bash
chmod -R 775 storage bootstrap/cache
```

If your host uses a different user model, adjust permissions accordingly.

## 8. Optimize for Production

Run these commands after deployment:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

If something goes wrong after caching, clear caches:

```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

## 9. Queue and Scheduler

This backend currently works without a worker process if you use:

```env
QUEUE_CONNECTION=sync
```

That is the simplest setup for shared hosting.

There is no special scheduler setup required unless you later add scheduled commands.

## 10. Web Server Notes

For Apache hosting:
- Make sure `mod_rewrite` is enabled
- The Laravel `.htaccess` inside `public/` must be used

For Nginx hosting:
- The site root must point to `public/`
- Requests should be forwarded to `public/index.php`

## 11. API Check After Deploy

After deployment, test these endpoints:

```text
GET  /api/hello
POST /api/auth/login
GET  /api/jobs
GET  /api/timesheets
```

For protected routes, send:

```text
Authorization: Bearer <token>
```

## 12. Default Seeded Login

If you ran the database seeder, the default admin account is:

```text
username: admin
password: 123456
```

Change this immediately on any real server.

## 13. If the Host Cannot Point to `public/`

If you must use `public_html/` as the only web root:

1. Upload the Laravel project outside `public_html/`
2. Copy the contents of this project's `public/` folder into `public_html/`
3. Edit `public_html/index.php`
4. Update these two paths to the real project location:

Example:

```php
require __DIR__.'/../lecotimesheets_backend/vendor/autoload.php';

(require_once __DIR__.'/../lecotimesheets_backend/bootstrap/app.php')
    ->handleRequest(Illuminate\Http\Request::capture());
```

Be careful with these paths. A wrong path will break the site.

## 14. Troubleshooting

If you get `500 Internal Server Error`:
- Check `storage/logs/laravel.log`
- Confirm `APP_KEY` exists
- Confirm `JWT_SECRET` exists
- Confirm `storage/` and `bootstrap/cache/` are writable
- Confirm the domain points to `public/`

If login fails:
- Check `JWT_SECRET`
- Check `JWT_ALGO=HS256`
- Check that the user exists in the database

If database connection fails:
- Recheck `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- Confirm the database user has access to that database

If routes return 404:
- Confirm the domain root points to `public/`
- Confirm rewrite rules are enabled

## 15. Suggested Production Values

For simple shared hosting:

```env
APP_ENV=production
APP_DEBUG=false
LOG_LEVEL=error
CACHE_STORE=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
```

## 16. Deployment Checklist

- Upload code
- Upload or install `vendor`
- Create `.env`
- Set `APP_KEY`
- Set `JWT_SECRET`
- Configure database
- Run migrations
- Set folder permissions
- Point domain to `public`
- Cache config/routes/views
- Test login and API endpoints
