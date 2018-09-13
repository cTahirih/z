<?php
namespace Base\Controller\Plugin\Factory;

use Base\Controller\Plugin\GetRender;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @package Base
 * @author Jaime G. Wong <j@jgwong.org>
 */
class GetRenderFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $serviceLocator
     * @param string $requestedName
     * @param array $options
     * @return GetRender
     */
    public function __invoke(ContainerInterface $serviceLocator, $requestedName, array $options = null)
    {
        return new GetRender(
            $serviceLocator->get('ViewRenderer')
        );
    }
}
