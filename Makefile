DC=docker-compose
DCEXEC=${DC} exec
DCEXEC_PHP=${DCEXEC} -u 1000 php

up:
	${DC} up -d --build

down:
	${DC} down


install: up composer-install migrate assets consume

bash:
	${DCEXEC_PHP} bash

cacl:
	${DCEXEC_PHP} php -d memory_limit=-1 bin/console ca:cl

composer-install:
	${DCEXEC_PHP} composer install

router:
	${DCEXEC} php bin/console debug:router
# Migrate database migrations
migrate:
	$(DCEXEC_PHP) php bin/console doctrine:migrations:migrate --no-interaction

# Autofix codestyle
phpcsfix:
	${DCEXEC_PHP} vendor/bin/php-cs-fixer fix

consume:
	${DCEXEC_PHP} php bin/console messenger:consume async

assets:
	${DCEXEC_PHP} php bin/console assets:install