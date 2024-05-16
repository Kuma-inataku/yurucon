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

.PHONY: csfix-exec
csfix-exec:
	./tools/php-cs-fixer/vendor/bin/php-cs-fixer fix -v --diff

# git
.PHONY: git-dev-pull
git-dev-pull :
	git pull origin develop

# artisan