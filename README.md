# SETUP

```sh:
composer install
php artisan migrate
php artisan db:seed
```

## SOME COMMANDS:

### OPEN DEV ENV.:

```sh
php artisan serve --host localhost --port=3000
```

### MAKE MODEL:
```sh:
php artisan make:model User -m
```


### MIGRATE:
```sh:
php artisan migrate
```

### SEEDS:

Make a new seed:
```sh
php artisan make:seeder UserSeeder
```

Run all seeds:
```sh
php artisan db:seed
```

Run some seeds:
```sh
php artisan db:seed --class=UserSeeder
```

### MAKE CONTROLLER

```sh:
php artisan make:controller UserController
```

## HOW TO DEPLOY

Update file .env
Chmod some files in this folder: storage (logs, view), bootstrap/cache
Access by URL like this: https://timesheets-test.codingbombs.com/server/public/index.php/api
