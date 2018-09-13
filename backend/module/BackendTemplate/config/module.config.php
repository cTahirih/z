<?php
namespace BackendTemplate;

use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'view_helpers' => [
        'factories' => [
            View\Helper\Partial::class =>
                View\Helper\Factory\PartialFactory::class
        ],
        
        'aliases' => [
            'partial' => View\Helper\Partial::class,
        ],
    ],
];
