<?php
namespace Website;

$inProduction = (APP_ENV == 'production');

return [
    'router' => [
        'routes' => include(__DIR__ . '/routes.php'),
    ],
    
    'controllers' => [
        'factories' => [
            'Website\Controller\WebsiteController' =>
                'Website\Controller\Factory\WebsiteControllerFactory',
        ],
    ],
    
    'service_manager' => [
        'factories' => [
        ],
    ],
    
    'form_elements' => [
        'invokables' => [
        ],
    ],
    
    'view_manager' => [
        'display_not_found_reason' => ($inProduction == false),
        'display_exceptions'       => ($inProduction == false),
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout' =>
                __DIR__ . '/../view/layout/layout.phtml',
            'error/404'     =>
                __DIR__ . '/../view/error/404-' . ($inProduction ? 'prod' : 'dev') . '.phtml',
            'error/index'   =>
                __DIR__ . '/../view/error/index-' . ($inProduction ? 'prod' : 'dev') . '.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ],
            ],
        ],
    ],
];
