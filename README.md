# Task for Fullstack Developer

#Steps

1. Clone repo, rename env.example to .env. Add the following parameters to .env:
`GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`,`GOOGLE_CLIENT_REDIRECT` with their corresponding values
2. `npm install`
3. `npm run production`
4. `docker-compose build`
5 `docker-compose up -d`
5. Enter php container bash with `docker-compose exec app bash`
6. Within container, run 
`mkdir storage/app/public/pictures`
`php artisan storage:link`
`composer install`
`php artisan migrate`
`php artisan db:seed`

Visit http://localhost
