# Veles unit-tests
Unit-tests for Veles framework

![PHPUnit 9 compatible][compatibility img]

## Docker run

    docker run -ti \
      -v /local/path/to/phpunit-9.phar:/usr/bin/phpunit \
      -v /local/path/to/Veles:/var/www/Veles \
      -v /local/path/to/Veles-unit-tests:/var/www/Veles/Tests \
      -w /var/www/Veles \
      -v /local/path/to/override.ini:/etc/php/7.3/cli/conf.d/99-override.ini \
      -u $(id -u):$(id -g) \
      nafigat0r/php-cli:7.4 \
      phpunit -c Tests/phpunit.xml

#### Coverage

    docker run -ti \
      -v /local/path/to/phpunit-9.phar:/usr/bin/phpunit \
      -v /local/path/to/Veles:/var/www/Veles \
      -v /local/path/to/Veles-unit-tests:/var/www/Veles/Tests \
      -v /local/path/to/override.ini:/etc/php/7.3/cli/conf.d/99-override.ini \
      -w /var/www/Veles \
      -u $(id -u):$(id -g) \
      nafigat0r/php-cli:7.4 \
      sh -c \
        'phpunit -c Tests/phpunit.xml
         --coverage-html /var/www/Veles/coverage-report'

[compatibility img]: https://img.shields.io/badge/PHPUnit-v9_compatible-brightgreen.svg
