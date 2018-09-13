<?php
use Base\Env;
use Zend\Mvc\Application;
use Zend\Stdlib\ArrayUtils;

chdir(dirname(__DIR__ . '/../../../../'));

// Setup default environment
Env::set('production');

// Retrieve configuration
$appConfig = require 'config/application.config.php';
if (file_exists('config/development.config.php')) {
    $appConfig = ArrayUtils::merge($appConfig, require 'config/development.config.php');
}

echo "- Initializing the ZF3 application" . PHP_EOL;
$app = Application::init($appConfig);
$serviceManager = $app->getServiceManager();

echo "- Ready" . PHP_EOL;

echo PHP_EOL;
