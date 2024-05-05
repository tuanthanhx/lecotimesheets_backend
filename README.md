## SOME COMMANDS:

### OPEN DEV ENV.:

```sh
php artisan serve --host localhost --port=3000
```

### MIGRATE:
```sh:
php artisan db:seed
php artisan db:seed --class=userSeeder
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

## SOME PASSWORD:

DB in production:

DB Name: lecopain_timesheets_2024
Username: lecopain_timesheets_2024
Password: P7m2Vk05lPFk
