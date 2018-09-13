<?php
namespace AdminAuth2;

use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => include __DIR__ . '/routes.php',
    ],
    
    'controllers' => [
        'factories' => [
            'AdminAuth2\Controller\AdminAuth2BaseController' =>
                InvokableFactory::class,
            'AdminAuth2\Controller\LoginController' =>
                'AdminAuth2\Controller\Factory\LoginControllerFactory',
            'AdminAuth2\Controller\DashboardController' =>
                'AdminAuth2\Controller\Factory\DashboardControllerFactory',
            'AdminAuth2\Controller\AdminUsersController' =>
                'AdminAuth2\Controller\Factory\AdminUsersControllerFactory',
            'AdminAuth2\Controller\AdminRolesController' =>
                'AdminAuth2\Controller\Factory\AdminRolesControllerFactory',
        ],
    ],
    
    'service_manager' => [
        'factories' => [
            'AdminAuth2\Session' =>
                'AdminAuth2\Service\Factory\SessionFactory',
            
            'AdminAuth2\Service\AdminCoreService' =>
                'AdminAuth2\Service\Factory\AdminCoreServiceFactory',
            'AdminAuth2\Service\ResourceService' =>
                'AdminAuth2\Service\Factory\ResourceServiceFactory',
            
            'AdminAuth2\Form\AdminUserForm' =>
                'AdminAuth2\Form\Factory\AdminUserFormFactory',
            'AdminAuth2\Provider\AdminUserProvider' =>
                'AdminAuth2\Provider\Factory\AdminUserProviderFactory',
            'AdminAuth2\Service\AdminUserService' =>
                'AdminAuth2\Service\Factory\AdminUserServiceFactory',
            
            'AdminAuth2\Form\AdminRoleForm' =>
                'AdminAuth2\Form\Factory\AdminRoleFormFactory',
            'AdminAuth2\Provider\AdminRoleProvider' =>
                'AdminAuth2\Provider\Factory\AdminRoleProviderFactory',
            'AdminAuth2\Service\AdminRoleService' =>
                'AdminAuth2\Service\Factory\AdminRoleServiceFactory',
            'AdminAuth2\Provider\AdminUserResourceProvider' =>
                InvokableFactory::class,
            'AdminAuth2\Provider\AdminRoleResourceProvider' =>
                InvokableFactory::class,
            
            'AdminAuth2\Skelsus\Console\Command\ChangeUserPasswordCommand' =>
                'AdminAuth2\Skelsus\Console\Command\Factory\ChangeUserPasswordCommandFactory',
            'AdminAuth2\Skelsus\Console\Command\CreateSuperUserCommand' =>
                'AdminAuth2\Skelsus\Console\Command\Factory\CreateSuperUserCommandFactory',
            'AdminAuth2\Skelsus\Console\Command\UpdateAdminPermsCommand' =>
                'AdminAuth2\Skelsus\Console\Command\Factory\UpdateAdminPermsCommandFactory',
        ],
    ],
    
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    
    'view_helpers' => [
        'invokables' => [
            'routeOrString' => 'AdminAuth2\ViewHelper\RouteOrString',
        ],
    ],
    
    // Doctrine config
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
                ]
            ]
        ]
    ],
    
    'adminauth2' => [
        'resources' => [
            'AdminAuth2\Provider\AdminRoleResourceProvider',
            'AdminAuth2\Provider\AdminUserResourceProvider',
        ],
        'providers' => [
            'AdminAuth2\Provider\AdminUserProvider',
            'AdminAuth2\Provider\AdminRoleProvider',
        ],
    ],
];
