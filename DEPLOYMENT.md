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

This project is pinned to PHP `8.2.0` in `composer.json`:

```json
"config": {
    "platform": {
        "php": "8.2.0"
    }
}
```

Keep this pin when deploying to shared hosting that supports PHP 8.2 maximum. Without it, Composer may install newer dependencies that require PHP 8.4+, which can cause this runtime error:

```text
Composer detected issues in your platform: Your Composer dependencies require a PHP version ">= 8.4.1".
```

If the hosting server does not support Composer, run this locally first:

```bash
composer install --no-dev --optimize-autoloader
```

Then upload the whole project including `vendor`.

If the server supports Composer, upload the project and run:

```bash
composer install --no-dev --optimize-autoloader
```

Do not upload stale route/config cache files from `bootstrap/cache/`. In particular, remove old files such as:

```text
bootstrap/cache/routes-v7.php
bootstrap/cache/config.php
```

They can make the server ignore newly uploaded routes or `.env` changes.

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
DEPLOY_SECRET=your_long_random_deploy_secret

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
- `DEPLOY_SECRET` is only needed if you must run migrations/seeders from the browser because the host has no SSH or command runner
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

For production, seed only the admin user:

```bash
php artisan db:seed --class=ProductionAdminSeeder --force
```

This creates or updates one administrator account:

```text
username: admin
password: ChangeThisAdminPassword123!
```

Important:
- Change this password immediately after the first successful login.
- You can also edit `database/seeders/ProductionAdminSeeder.php` before uploading if you want a different temporary password.

For local development or demo data only, you can run:

```bash
php artisan db:seed --force
```

Warning:
- Seeding adds demo users, jobs, and timesheets.
- Do not run `php artisan db:seed --force` on a live production database unless you want demo data.

### If the host cannot run commands

Some shared hosting plans do not provide SSH, cron commands, or an Artisan command runner. For that case, this project has a temporary protected browser endpoint:

```text
GET /deploy/database
GET /api/deploy/database
```

Before uploading, set a long random secret in the production `.env`:

```env
DEPLOY_SECRET=your_long-random-secret-here
```

Then open this URL in the browser to run migrations and seed only the production admin:

```text
https://api.your-domain.com/deploy/database?token=your_long-random-secret-here
```

If the backend is deployed in a subfolder and API URLs include `/public/api`, use the API version instead:

```text
https://your-domain.com/timesystem_server/public/api/deploy/database?token=your_long-random-secret-here
```

This runs:

```bash
php artisan migrate --force
php artisan db:seed --class=ProductionAdminSeeder --force
```

For demo data on an empty database, use:

```text
https://api.your-domain.com/deploy/database?token=your_long-random-secret-here&seed=demo
```

Subfolder API example:

```text
https://your-domain.com/timesystem_server/public/api/deploy/database?token=your_long-random-secret-here&seed=demo
```

Demo mode runs the normal `DatabaseSeeder`, but it refuses to run if `users`, `jobs`, or `timesheets` already contain data.

Security notes:
- The endpoint returns 404 unless `DEPLOY_SECRET` is set and the `token` query value matches it.
- Use a long, random, one-time value.
- After the database is migrated and seeded, remove `DEPLOY_SECRET` from the production `.env`, or remove the temporary route from `routes/web.php`.
- Do not leave the deploy URL or secret in chat logs, public docs, issue trackers, or screenshots.

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

## 12. Production Admin Login

If you ran the production admin seeder:

```text
username: admin
password: ChangeThisAdminPassword123!
```

Change this immediately on any real server.

Only use this command in production:

```bash
php artisan db:seed --class=ProductionAdminSeeder --force
```

Do not use the default seeder in production:

```bash
php artisan db:seed --force
```

The default seeder is for local/demo data and adds demo users, jobs, and timesheets.

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
- Confirm `bootstrap/cache/routes-v7.php` is not an old cached route file from another build

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
- Set `DEPLOY_SECRET` only if browser-based migration/seeding is needed
- Configure database
- Run migrations with Artisan, or open `/deploy/database?token=...` if there is no shell access
- Run `php artisan db:seed --class=ProductionAdminSeeder --force`, or use the browser deploy endpoint
- Remove `DEPLOY_SECRET` or remove the temporary deploy route after seeding
- Set folder permissions
- Point domain to `public`
- Cache config/routes/views
- Test login and API endpoints
