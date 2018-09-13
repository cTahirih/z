<?php
/**
 * Routes configuration file
 */

use Base2\Route;

return [
    'home' => Route::render('/', 'website/index'),
    'login' => Route::render('/login', 'website/login')
];
