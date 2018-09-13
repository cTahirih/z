<?php
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'controller_plugins' => [
        'factories' => [
            'RenderCsv\RenderCsvPlugin' =>
                InvokableFactory::class
        ],
        
        'aliases' => [
            'renderCsv' => 'RenderCsv\RenderCsvPlugin',
        ],
    ],
];
