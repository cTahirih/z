<?php
namespace Base\Db;

use Interop\Container\ContainerInterface;
use PDO;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;

/**
 * Returns the DB Adapter's PDO resource.
 *
 * @package Base
 * @author Jaime G. Wong <j@jgwong.org>
 */
class PdoResourceFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $serviceLocator
     * @param string $requestedName
     * @param array $options
     * @return PDO PDO resource
     */
    public function __invoke(ContainerInterface $serviceLocator, $requestedName, array $options = null)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $pdo       = $dbAdapter->getDriver()->getConnection()->getResource();
        
        if (!$pdo instanceof PDO) {
            throw new ServiceNotCreatedException('Connection resource must be an instance of PDO.');
        }
        
        return $pdo;
    }
}
