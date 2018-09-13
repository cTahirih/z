<?php
use Base\Env;

error_reporting(E_ALL);
ini_set('display_startup_errors', true);
ini_set('display_errors', true);
ini_set('html_errors', true);

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));
 
// Composer autoloading
include __DIR__ . '/../vendor/autoload.php';

// Setup default environment
Env::set('testing');
