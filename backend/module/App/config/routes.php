<?php
namespace App;

use Base\Route;

return [
    'logout' => [
        'type' => 'literal',
        'options' => [
            'route' => '/logout',
            'defaults' => [
                'controller' => 'App\Controller\LoginController',
                'action' => 'logout',
            ],
        ],
    ],
    
    'login' => [
        'type' => 'literal',
        'options' => [
            'route' => '/',
            'defaults' => [
                'controller' => 'App\Controller\LoginController',
                'action' => 'login',
            ],
        ],
    ],
    
    'dashboard' => [
        'type' => 'literal',
        'options' => [
            'route' => '/dashboard',
            'defaults' => [
                'controller' => 'App\Controller\DashboardController',
                'action' => 'dashboard',
            ],
        ],
    ],
    
    
    /** CapsuleController ********************************************/
    'capsules' => [
        'type' => 'literal',
        'options' => [
            'route' => '/reports/capsules',
            'defaults' => [
                'controller' => 'App\Controller\CapsuleController',
            ],
        ],
        'child_routes' => [
            'capsules_total' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/capsules-total',
                    'defaults' => [
                        'action' => 'capsulesTotal',
                    ],
                ],
                'may_terminate' => true,
            ],
            
            'capsules_average_by_user' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/capsules-average-by-user',
                    'defaults' => [
                        'action' => 'capsulesAverageByUser',
                    ],
                ],
                'may_terminate' => true,
            ],
            
            'capsules_quantity_by_month' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/capsules-quantity-by-month',
                    'defaults' => [
                        'action' => 'capsulesQuantityByMonth',
                    ],
                ],
                'may_terminate' => true,
            ],
        ],
    ],
    
    
    /** MachineController ********************************************/
    'machines' => [
        'type' => 'literal',
        'options' => [
            'route' => '/reports/machines',
            'defaults' => [
                'controller' => 'App\Controller\MachineController',
            ],
        ],
        'child_routes' => [
            'machines_total' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/machines-total',
                    'defaults' => [
                        'action' => 'machinesTotal',
                    ],
                ],
                'may_terminate' => true,
            ],
            
            'machines_average_by_user' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/machines-average-by-user',
                    'defaults' => [
                        'action' => 'machinesAverageByUser',
                    ],
                ],
                'may_terminate' => true,
            ],
            
            'machines_quantity_by_month' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/machines-quantity-by-month',
                    'defaults' => [
                        'action' => 'machinesQuantityByMonth',
                    ],
                ],
                'may_terminate' => true,
            ],
            
            'machines_acquisition_average_by_user' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/machines-acquisition-average-by-user',
                    'defaults' => [
                        'action' => 'machinesAcquisitionAverageByUser',
                    ],
                ],
                'may_terminate' => true,
            ],
            
            'machines_best_month' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/machines-best-month',
                    'defaults' => [
                        'action' => 'machinesBestMonth',
                    ],
                ],
                'may_terminate' => true,
            ],
        ],
    ],
    
    
    /** ClaimController **********************************************/
    'claims' => [
        'type' => 'literal',
        'options' => [
            'route' => '/reports/claims',
            'defaults' => [
                'controller' => 'App\Controller\ClaimController',
            ],
        ],
        'child_routes' => [
            'claims_total' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/claims-total',
                    'defaults' => [
                        'action' => 'claimsTotal',
                    ],
                ],
                'may_terminate' => true,
            ],
            
            'claims_average_by_user' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/claims-average-by-user',
                    'defaults' => [
                        'action' => 'claimsAverageByUser',
                    ],
                ],
                'may_terminate' => true,
            ],
            
            'claims_quantity_by_month' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/claims-quantity-by-month',
                    'defaults' => [
                        'action' => 'claimsQuantityByMonth',
                    ],
                ],
                'may_terminate' => true,
            ],
            
            'claims_acquisition_average_by_user' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/claims-acquisition-average-by-user',
                    'defaults' => [
                        'action' => 'claimsAcquisitionAverageByUser',
                    ],
                ],
                'may_terminate' => true,
            ],
        ],
    ],
];
