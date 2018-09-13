<?php
namespace App\Controller\Factory;

use App\Controller\MachineController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class MachineControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return MachineController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new MachineController(
            $container->get('App\Infrastructure\Session'),
            $container->get('App\InputFilter\DateRangeInputFilter'),
            $container->get('App\Domain\Specification\ValidDateRangeSpecification')
        );
    }
}
