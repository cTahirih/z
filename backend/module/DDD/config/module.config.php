<?php
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'service_manager' => [
        'factories' => [
            'DDD\Event\EventRecorder' =>
                InvokableFactory::class,
            'DDD\Event\EventDispatcher' =>
                InvokableFactory::class,
            'DDD\Event\EventTacticianMiddleware' =>
                'DDD\Event\Factory\EventTacticianMiddlewareFactory',
        ],
    ],
    
    'controller_plugins' => [
        'factories' => [
            'DDD\Controller\Plugin\EventDispatcherPlugin' =>
                'DDD\Controller\Plugin\Factory\EventDispatcherPluginFactory'
        ],
        
        'aliases' => [
            'commandBus' => 'tacticianCommandBus',
            'eventDispatcher' => 'DDD\Controller\Plugin\EventDispatcherPlugin',
        ],
    ],
    
    'tactician' => [
        'default-locator' => 'TacticianModule\Locator\ClassnameZendLocator',
        'middleware' => [
            'DDD\Event\EventTacticianMiddleware' => 100,
        ],
    ],
];
