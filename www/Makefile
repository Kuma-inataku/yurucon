# PHPUnit
.PHONY: phpunit
phpunit:
	./vendor/bin/phpunit

# PHPStan
.PHONY: stan
stan:
	./vendor/bin/phpstan analyse

# php-cs-fix
.PHONY: csfix-dry
csfix-dry:
	./tools/php-cs-fixer/vendor/bin/php-cs-fixer fix -v --diff --dry-run

.PHONY: csfix
csfix:
	./tools/php-cs-fixer/vendor/bin/php-cs-fixer fix -v --diff

# artisan
.PHONY: fresh
fresh:
	php artisan migrate:fresh --seed

