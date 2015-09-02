[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/tonis-io/error-handler/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/tonis-io/error-handler/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/tonis-io/error-handler/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/tonis-io/error-handler/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/tonis-io/error-handler/badges/build.png?b=master)](https://scrutinizer-ci.com/g/tonis-io/error-handler/build-status/master)

# Tonis\ErrorHandler

Tonis\ErrorHandler is simple middleware that logs errors using your choice of PSR-3 compatible loggers.

Composer
--------

```
composer require tonis-io/error-handler
```

Usage
-----

```php
// create an instance and give it your psr-3 logger
$responseTime = new \Tonis\ErrorHandler(new \Monolog\Logger('default'));

// add $responseTime to your middleware queue
```
