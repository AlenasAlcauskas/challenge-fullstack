# Task for Fullstack Developer

#Steps

1. Clone repo, rename env.example to .env. `mv .env.example .env` 
Add the following parameters to .env:
`GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`,`GOOGLE_CLIENT_REDIRECT` with their corresponding values
2. `npm install && npm run production`
3. `docker-compose build`
5 `docker-compose up -d`
4. Enter php container bash with `docker-compose exec app bash`
5. Within container, run 
`mkdir storage/app/public/pictures`
`composer install`
`php artisan storage:link`
`php artisan migrate`
Seed users and comments with `php artisan db:seed`

Visit http://localhost/login
Use admin@admin.lt 'test1234' for credentials or use google login
