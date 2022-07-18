# symfony-maidAssist
https://www.twilio.com/blog/get-started-docker-symfony

sudo docker exec -it ba025185a44a bash

sudo docker inspect -f \
'{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' \
9c0778fa25be




install : 
composer install
php bin/console make:migration
composer require symfony/webpack-encore-bundle
npm install
npm run watch

php bin/console doctrine:fixtures:load