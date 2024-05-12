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

## SOME PASSWORD:

DB in production:

DB Name: lecopain_timesheets_2024
Username: lecopain_timesheets_2024
Password: P7m2Vk05lPFk
