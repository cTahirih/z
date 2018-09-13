<?php
namespace AdminAuth2;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'admin' => [
        'type' => Segment::class,
        'options' => array(
            'route' => '/admin[/]',
            'defaults' => array(
                'controller' => 'AdminAuth2\Controller\LoginController',
                'action' => 'login',
            ),
        ),
        'may_terminate' => true,
        
        'child_routes' => [
            'dashboard' => array(
                'type' => Literal::class,
                'options' => array(
                    'route' => 'dashboard',
                    'defaults' => array(
                        'controller' => 'AdminAuth2\Controller\DashboardController',
                        'action' => 'index',
                    ),
                ),
            ),
            
            'logout' => array(
                'type' => Literal::class,
                'options' => array(
                    'route' => 'logout',
                    'defaults' => array(
                        'action' => 'logout',
                    ),
                ),
            ),
            
            'admin_users' => Route::route([
                'route' => 'admin_users',
                'controller' => 'AdminAuth2\Controller\AdminUsersController'
            ]),
            
            'admin_roles' => Route::route([
                'route' => 'admin_roles',
                'controller' => 'AdminAuth2\Controller\AdminRolesController'
            ]),
        ],
    ],
];
