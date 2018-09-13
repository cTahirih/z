<?php
/**
 * This file is part of AdminAuth2 Zend Framework 2 module.
 */

namespace AdminAuth2\Provider;

use AdminAuth2\Entity\AdminRole;
use AdminAuth2\Provider\CrudProviderInterface;
use AdminAuth2\Provider\Doctrine\DoctrineCrudProviderTrait;
use AdminAuth2\Provider\Doctrine\DoctrineListProviderTrait;
use AdminAuth2\Provider\ListProviderInterface;
use AdminAuth2\Provider\ListProviderTrait;
use AdminAuth2\Provider\MenuIdInterface;
use AdminAuth2\Service\ResourceService;
use Doctrine\Orm\EntityManager;
use Iterator;
use Zend\Form\Form;

/**
 * @see CrudProviderInterface
 * @see Iterator
 * @see ListProviderInterface
 * @see MenuIdInterface
 * @see ResourcesProviderInterface
 * @package AdminAuth2
 * @version v2.0.0
 * @author Jaime G. Wong <jaime.wong@nodosdigital.pe>
 */
class AdminRoleProvider implements Iterator, CrudProviderInterface, ListProviderInterface, MenuIdInterface, ResourcesProviderInterface
{
    use ListProviderTrait;
    use DoctrineCrudProviderTrait {
        add as doctrineAdd;
        getData as doctrineGetData;
    }
    use DoctrineListProviderTrait;
    
    
    protected $form;
    
    protected $resourceService;
    
    
    public function __construct(AdminRoleResourceProvider $adminRoleResourceProvider, EntityManager $entityManager, Form $adminRoleForm, ResourceService $resourceService)
    {
        $this->name             = 'Roles de Admin';
        $this->route            = 'admin/admin_roles';
        $this->entityClass      = AdminRole::class;
        $this->resourceProvider = $adminRoleResourceProvider;
        
        $this->initializeDoctrineCrudProvider($entityManager);
        
        $this->form            = $adminRoleForm;
        $this->resourceService = $resourceService;
    }
    
    
    public function getListFields()
    {
        return [
             'ID'     => 'getId',
             'Name'   => 'getName',
             'Active' => 'getActive'
        ];
    }
    
    
    public function getForm($action)
    {
        return $this->form;
    }
    
    
    public function add($data)
    {
        $data['resources'] = json_encode($this->resourceService->parseValueOptionsToNestedArray($data['resources']));
        return $this->doctrineAdd($data);
    }
    
    
    public function getData()
    {
        $data = $this->doctrineGetData();
        $data['resources'] = $this->resourceService->parseNestedArrayToValueOptions(json_decode($data['resources'], true));
        return $data;
    }
    
    
    public function getResourceName()
    {
        return $this->resourceProvider->getResourceName();
    }
    
    
    public function getPrivileges()
    {
        return $this->resourceProvider->getPrivileges();
    }
    
    
    public function getResourcesAsArray()
    {
        return $this->resourceProvider->getResourcesAsArray();
    }
    
    
    public function getMenuId()
    {
        return ['admin_users', 'admin_users_roles'];
    }
}
