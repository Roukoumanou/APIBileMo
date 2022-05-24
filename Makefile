install: ## Installation et démarrage de l'application
	php bin/console d:d:c
	php bin/console d:s:u -f
	php bin/console d:f:l --no-interaction
	composer install
	php -S localhost:8000 -t public

