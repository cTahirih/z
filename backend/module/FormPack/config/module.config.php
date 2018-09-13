<?php
namespace FormPack;

use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'controller_plugins' => [
        'factories' => [
            'FormPack\Controller\Plugin\FormMessages' =>
                InvokableFactory::class,
            'FormPack\Controller\Plugin\FormJsonResponse' =>
                InvokableFactory::class,
        ],
        
        'aliases' => [
            'formMessages' => 'FormPack\Controller\Plugin\FormMessages',
            'formJsonResponse' => 'FormPack\Controller\Plugin\FormJsonResponse',
        ]
    ],
    
    'view_helpers' => [
        'invokables' => [
            'FormPack\View\Helper\FormOptionalFile' =>
                InvokableFactory::class,
            'FormPack\View\Helper\FormImageFile' =>
                InvokableFactory::class,
        ],
        
        'aliases' => [
            'formoptionalfile' => 'FormPack\View\Helper\FormOptionalFile',
            'formimagefile' => 'FormPack\View\Helper\FormImageFile',
        ],
    ],
];
