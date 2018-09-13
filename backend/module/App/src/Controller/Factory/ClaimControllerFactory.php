<?php
namespace App\Controller\Factory;

use App\Controller\ClaimController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class ClaimControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return ClaimController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ClaimController(
            $container->get('App\Infrastructure\Session'),
            $container->get('App\InputFilter\DateRangeInputFilter'),
            $container->get('App\Domain\Specification\ValidDateRangeSpecification')
        );
    }
}
