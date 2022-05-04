install: ## Installation et démarrage de l'application
	php bin/console d:d:c
	php bin/console d:m:m --no-interaction
	php bin/console d:s:u -f
	php bin/console d:f:l --no-interaction
	rm -Rf var
	composer install
	yarn run build
	php -S localhost:8000 -t public