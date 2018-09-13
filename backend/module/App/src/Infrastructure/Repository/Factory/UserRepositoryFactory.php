<?php
namespace App\Infrastructure\Repository\Factory;

use App\Infrastructure\Repository\UserRepository;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class UserRepositoryFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return UserRepository
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new UserRepository(
            $container->get('Zend\Db\Adapter\Adapter')
        );
    }
}
