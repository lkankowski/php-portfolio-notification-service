##################
# SHELL Commands #
##################
shell:
	@docker compose exec php-fpm sh

shell-debug:
	@docker compose exec php-fpm env PHP_IDE_CONFIG='serverName=localhost' sh

########################
# Application Commands #
########################

php-cs:
	vendor/bin/php-cs-fixer fix -v --allow-risky=yes

php-cs-no-cache:
	vendor/bin/php-cs-fixer fix -v --allow-risky=yes --using-cache=no

php-stan:
	vendor/bin/phpstan analyse -c phpstan.neon --memory-limit=-1

php-stan-baseline:
	vendor/bin/phpstan --generate-baseline --allow-empty-baseline

deptrac:
	vendor/bin/deptrac

deptrac-baseline:
	vendor/bin/deptrac --formatter=baseline || true

test:
	vendor/bin/codecept run $(path)

test-unit:
	vendor/bin/codecept run tests/unit

test-functional:
	vendor/bin/codecept run tests/functional

test-acceptance:
	vendor/bin/codecept run tests/acceptance

test-integration:
	vendor/bin/codecept run tests/integration

test-coverage:
	XDEBUG_MODE=coverage vendor/bin/codecept run unit --coverage

test-coverage-report:
	XDEBUG_MODE=coverage vendor/bin/codecept run unit --coverage --coverage-html

infection:
	XDEBUG_MODE=coverage SYMFONY_DEPRECATIONS_HELPER=weak php -d memory_limit=4G vendor/bin/infection --min-msi=75 --threads=4 -s --test-framework-options="tests/unit/" --only-covered

xdebug-enable:
	@echo 'zend_extension=xdebug.so' > /etc/php/conf.d/50_xdebug.ini
	@echo 'xdebug.mode = debug' >> /etc/php/conf.d/50_xdebug.ini
	@echo 'xdebug.client_host = host.docker.internal' >> /etc/php/conf.d/50_xdebug.ini
	@echo 'xdebug.client_port = 9100' >> /etc/php/conf.d/50_xdebug.ini
	@echo 'xdebug.start_with_request=yes' >> /etc/php/conf.d/50_xdebug.ini
	@echo 'xdebug.idekey = PHPSTORM' >> /etc/php/conf.d/50_xdebug.ini
	@echo 'xdebug.discover_client_host=true' >> /etc/php/conf.d/50_xdebug.ini
	@make restart-php

xdebug-disable:
	@echo 'zend_extension=xdebug.so' > /etc/php/conf.d/50_xdebug.ini
	@echo 'xdebug.mode = off' >> /etc/php/conf.d/50_xdebug.ini
	@echo 'xdebug.client_port = 9100' >> /etc/php/conf.d/50_xdebug.ini
	@echo 'xdebug.start_with_request=false' >> /etc/php/conf.d/50_xdebug.ini
	@echo 'xdebug.discover_client_host=false' >> /etc/php/conf.d/50_xdebug.ini
	@make restart-php

pre-push:
	@make php-cs
	@make php-stan
	@make deptrac
	@make test

cache-clean:
	rm -rf var/cache/*
	rm -rf tests/_data/phiremock-expectations/*
	find tests/_output -type f ! -name .gitignore -exec rm -f {} \;
	find tests/_support/_generated -type f ! -name .gitignore -exec rm -f {} \;

pp:
	@make pre-push
