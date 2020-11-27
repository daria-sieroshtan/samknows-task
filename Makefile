execute_dev_checks: test check_code_style

test:
	bin/phpunit

check_code_style:
	php vendor/bin/phpcs --standard=psr12 src/ -n

fix_code_style:
	php vendor/bin/phpcbf --standard=psr12 src/ -n

run:
	php bin/console app:generate-reports
