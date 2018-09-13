<?php
/**
 * This file is part of AdminAuth2 Zend Framework 2 module.
 */

namespace AdminAuth2\Provider\Doctrine;

use AdminAuth2\Provider\CrudProviderInterface;
use AdminAuth2\Provider\ListProviderInterface;
use AdminAuth2\Provider\ListProviderTrait;
use AdminAuth2\Provider\MenuIdInterface;
use AdminAuth2\Provider\ResourcesProviderInterface;
use AdminAuth2\Provider\ResourcesProviderTrait;
use Doctrine\Orm\EntityManager;
use Iterator;

/**
 * Abstract CRUD Provider.
 *
 * @see CrudProviderInterface
 * @see DoctrineCrudProviderTrait
 * @see DoctrineListProviderTrait
 * @see Iterator
 * @see ListProviderInterface
 * @see ListProviderTrait
 * @see ResourcesProviderInterface
 * @see ResourcesProviderTrait
 * @package AdminAuth2
 * @version v2.0.0
 * @author Jaime Wong <jaime.wong@nodosdigital.pe>
 */
abstract class AbstractDoctrineCrudProvider implements Iterator, CrudProviderInterface, ListProviderInterface, ResourcesProviderInterface, MenuIdInterface
{
    use DoctrineCrudProviderTrait;
    use DoctrineListProviderTrait;
    use ListProviderTrait;
    use ResourcesProviderTrait;
    
    
    /**
     * Constructor
     *
     * @param EntityManager $entityManager
     * @return void
     * @since v1.0.0
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->initializeDoctrineCrudProvider($entityManager);
        $this->initializeResourceProvider();
    }
    
    
    /**
     * {@inheritDoc}
     */
    abstract public function getForm($action);
    
    
    /**
     * Returns this Provider's Menu ID
     *
     * @return array
     * @since v1.0.0
     */
    public function getMenuId()
    {
        return [$this->getResourceName()];
    }
}
