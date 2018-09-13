<?php
namespace Base;

use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'controllers' => [
        'factories' => [
            'Base\Controller\ViewRouteController' =>
                InvokableFactory::class
        ],
    ],
    
    'controller_plugins' => [
        'factories' => [
            Controller\Plugin\Render::class =>
                InvokableFactory::class,
            Controller\Plugin\GetRender::class =>
                Controller\Plugin\Factory\GetRenderFactory::class,
        ],
        
        'aliases' => [
            'render' => Controller\Plugin\Render::class,
            'getRender' => Controller\Plugin\GetRender::class,
        ],
    ],
    
    'view_helpers' => [
        'factories' => [
            View\Helper\FormError::class =>
               InvokableFactory::class
        ],
        
        'aliases' => [
            'formError' => View\Helper\FormError::class,
        ],
    ],
];
