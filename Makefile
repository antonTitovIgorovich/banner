test:
	php vendor/bin/phpunit --colors=always
migrate:
	php artisan migrate && php artisan migrate --env=testing	