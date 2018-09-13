<?php
/**
 * This file is part of AdminAuth2 Zend Framework 2 module.
 */

namespace AdminAuth2\Provider;

use AdminAuth2\Entity\AdminUser;
use AdminAuth2\Provider\CrudProviderInterface;
use AdminAuth2\Provider\Doctrine\DoctrineCrudProviderTrait;
use AdminAuth2\Provider\Doctrine\DoctrineListProviderTrait;
use AdminAuth2\Provider\ListHeader;
use AdminAuth2\Provider\ListProviderInterface;
use AdminAuth2\Provider\MenuIdInterface;
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
 * @author Jaime G. Wong <j@jgwong.org>
 */
class AdminUserProvider implements Iterator,
                                   CrudProviderInterface,
                                   ListProviderInterface,
                                   MenuProviderInterface,
                                   MenuIdInterface,
                                   ResourcesProviderInterface
{
    use ListProviderTrait;
    use DoctrineCrudProviderTrait {
        edit as doctrineEdit;
        getViewFields as doctrineGetViewFields;
    }
    use DoctrineListProviderTrait;
    
    
    /**
     * @var Form
     */
    protected $form;
    
    
    public function __construct(
        AdminUserResourceProvider $adminUserResourceProvider,
        EntityManager $entityManager,
        Form $adminUserForm
    ) {
        $this->name             = 'Usuarios de Admin';
        $this->route            = 'admin/admin_users';
        $this->entityClass      = AdminUser::class;
        $this->resourceProvider = $adminUserResourceProvider;
        $this->form             = $adminUserForm;
        
        $this->initializeDoctrineCrudProvider($entityManager);
    }
    
    
    public function getListFields()
    {
        return [
             'ID'       => 'getId',
             'Username' => 'getUsername',
             'Role'     => 'getRoleName',
             'Active'   => 'getActive',
             'IsSuperUser' => 'getIsSuperUser',
        ];
    }
    
    
    /**
     * {@inheritDoc}
     */
    public function getListHeaders()
    {
        return [
            'ID',
            'Nombre de Usuario',
            'Rol',
            'Activo',
            'Super Usuario',
        ];
    }
    
    
    public function getViewFields()
    {
        $fields = $this->doctrineGetViewFields();
        
        unset($fields['password']);
        unset($fields['role']);
        unset($fields['adminRolesId']);
        
        $fields['active']->setName('Active?');
        
        return $fields;
    }
    
    
    public function getForm($action)
    {
        $id = $this->getRecord()->getId();
        
        if ($action == 'add') {
            $id = 0;
        }
        
        $this->form->setId($id);
        
        return $this->form;
    }
    
    
    public function add($data)
    {
        $entity = $this->getRecord();
        $this->hydrator->hydrate($data, $entity);
        
        // Set reference to Role
        $roleReference = $this->entityManager->getReference('AdminAuth2\Entity\AdminRole', $entity->getAdminRolesId());
        $entity->setRole($roleReference);
        
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        
        return $entity->getId();
    }
    
    
    public function edit($data)
    {
        if (empty($data['password'])) {
            unset($data['password']);
        }
        
        return $this->doctrineEdit($data);
    }
    
    
    public function getMenus()
    {
        return [
            'admin_users' => [
                'title'       => 'Usuarios',
                'description' => 'Usuarios y Roles',
                'iconClass'   => 'pg pg-settings_small',
                'order'       => 10000,
                'children'    => [
                    'admin_users_users' => [
                        'title'     => 'Usuarios',
                        'url'       => ['admin/admin_users'],
                        'iconClass' => 'fa fa-users',
                        'order'     => '100',
                    ],
                    'admin_users_roles' => [
                        'title'     => 'Roles',
                        'url'       => ['admin/admin_roles'],
                        'iconClass' => 'fa fa-unlock-alt',
                        'order'     => '200',
                    ],
                ],
            ],
        ];
    }
    
    
    public function getMenuId()
    {
        return ['admin_users', 'admin_users_users'];
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
}
