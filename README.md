##This is a test Symfony console application for storing info about currency exchange and sending messages with `messenger` component
###First application run
Need to be installed php >= 7.4 and symfony >= 5.4. Then Run next commands:  
1. `composer install`
2. `php bin/console doctrine:migrations:migrate --no-interaction`
3. `php bin/console app:currency-exchange -vv` -- for run application

Tests:
`php bin/phpunit`
