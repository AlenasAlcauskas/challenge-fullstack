# Task for Fullstack Developer

#Steps

1. Clone repo
2. `npm install`
3. `docker-compose up -d -build`
4. Enter php container bash with `docker-compose exec app bash`
5. Within container, run 
`composer install`
`php artisan migrate`
`php artisan db:seed`

Visit http://localhost
