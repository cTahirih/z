<?php
/**
 * Configuration file for Testing environment
 */

error_reporting(E_ALL | E_ALL | E_STRICT | E_NOTICE);
ini_set('display_startup_errors', true);
ini_set('display_errors', true);
ini_set('html_errors', true);

return [
    'modules' => [
        'BackendTemplate',
        'BaseTest',
    ],
    
    'module_listener_options' => [
        'config_cache_enabled' => false,
        'module_map_cache_enabled' => false,
    ],
    
    'show_backend_template' => true,
];
