<?php
namespace App;

use Base\Env;
use Zend\ServiceManager\Factory\InvokableFactory;

$isProduction = Env::isProduction();

return [
    'router' => [
        'routes' => include __DIR__ . '/routes.php',
    ],
    
    'controllers' => [
        'factories' => [
            'App\Controller\LoginController' =>
                'App\Controller\Factory\LoginControllerFactory',
            'App\Controller\DashboardController' =>
                'App\Controller\Factory\DashboardControllerFactory',
            'App\Controller\CapsuleController' =>
                'App\Controller\Factory\CapsuleControllerFactory',
            'App\Controller\MachineController' =>
                'App\Controller\Factory\MachineControllerFactory',
            'App\Controller\ClaimController' =>
                'App\Controller\Factory\ClaimControllerFactory',
        ],
    ],
    
    'service_manager' => [
        'factories' => [
            'App\Infrastructure\Session' =>
                InvokableFactory::class,
            'App\Infrastructure\Csv\CsvReader' =>
                InvokableFactory::class,
            'App\InputFilter\DateRangeInputFilter' =>
                InvokableFactory::class,
            'App\Application\Service\ReportCacheService' =>
                'App\Application\Service\Factory\ReportCacheServiceFactory',
            'App\Tactician\Middleware\ReportCacheMiddleware' =>
                'App\Tactician\Middleware\Factory\ReportCacheMiddlewareFactory',
            
            // Repositories
            'App\Infrastructure\Repository\ReportRepository' =>
                'App\Infrastructure\Repository\Factory\ReportRepositoryFactory',
            'App\Infrastructure\Repository\UserRepository' =>
                'App\Infrastructure\Repository\Factory\UserRepositoryFactory',
            'App\Infrastructure\Repository\MachineRepository' =>
                'App\Infrastructure\Repository\Factory\MachineRepositoryFactory',
            'App\Infrastructure\Repository\CapsuleRepository' =>
                'App\Infrastructure\Repository\Factory\CapsuleRepositoryFactory',
            'App\Infrastructure\Repository\ClaimRepository' =>
                'App\Infrastructure\Repository\Factory\ClaimRepositoryFactory',
            'App\Infrastructure\Repository\ReportCacheRepository' =>
                'App\Infrastructure\Repository\Factory\ReportCacheRepositoryFactory',
            
            // Command Handlers
            'App\Application\Command\GetUserForLoginCommandHandler' =>
                'App\Application\Command\Factory\GetUserForLoginCommandHandlerFactory',
            'App\Application\Command\ImportUsersCsvCommandHandler' =>
                'App\Application\Command\Factory\ImportUsersCsvCommandHandlerFactory',
            'App\Application\Command\ImportMachinesCsvCommandHandler' =>
                'App\Application\Command\Factory\ImportMachinesCsvCommandHandlerFactory',
            'App\Application\Command\ImportUsersMachinesCsvCommandHandler' =>
                'App\Application\Command\Factory\ImportUsersMachinesCsvCommandHandlerFactory',
            'App\Application\Command\GetCapsuleReportCommandHandler' =>
                'App\Application\Command\Factory\GetCapsuleReportCommandHandlerFactory',
            'App\Application\Command\GetMachineReportCommandHandler' =>
                'App\Application\Command\Factory\GetMachineReportCommandHandlerFactory',
            'App\Application\Command\GetClaimReportCommandHandler' =>
                'App\Application\Command\Factory\GetClaimReportCommandHandlerFactory',
            
            // Specifications
            'App\Domain\Specification\ValidDateRangeSpecification' =>
                InvokableFactory::class,
        ],
    ],
    
    'form_elements' => [
        'factories' => [
            'App\Form\LoginForm' =>
                InvokableFactory::class,
            'App\Form\ReportForm' =>
                InvokableFactory::class,
        ],
        
        'shared' => [
            'App\Form\LoginForm' => true,
            'App\Form\ReportForm' => true,
        ],
    ],
    
    'view_manager' => [
        'display_not_found_reason' => ($isProduction == false),
        'display_exceptions' => ($isProduction == false),
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'error/404' => sprintf(
                __DIR__ . '/../view/error/404-%s.phtml',
                ($isProduction ? 'production' : 'development')
            ),
            'error/index' => sprintf(
                __DIR__ . '/../view/error/index-%s.phtml',
                ($isProduction ? 'production' : 'development')
            ),
        ],
        
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        
        'strategies' => [
            'ViewJsonStrategy',
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
