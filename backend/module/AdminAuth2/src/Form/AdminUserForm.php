<?php
namespace AdminAuth2\Form;

use AdminAuth2\Service\AdminRoleService;
use Zend\Form\Form;
use Zend\Db\Adapter\Adapter;
use Zend\InputFilter\InputFilterProviderInterface;

/**
 * @see InputFilterProviderInterface
 * @see Form
 * @package AdminAuth2
 * @author Jaime G. Wong <j@jgwong.org>
 */
class AdminUserForm extends Form implements InputFilterProviderInterface
{
    /**
     * @var Adapter
     */
    protected $dbAdapter;
    
    /**
     * @var int
     */
    protected $id;
    
    
    /**
     * @param Adapter $dbAdapter
     * @param AdminRoleService $adminRoleService
     * @return void
     */
    public function __construct(Adapter $dbAdapter, AdminRoleService $adminRoleService)
    {
        parent::__construct();
        
        $this->dbAdapter = $dbAdapter;
        
        $this->add([
            'type' => 'FormPack\Element\Text',
            'name' => 'username',
            'options' => [
                'label' => 'Nombre de Usuario',
            ],
        ]);
        
        $this->add([
            'type' => 'FormPack\Element\Name',
            'name' => 'name',
            'options' => [
                'label' => 'Nombre',
            ],
        ]);
        
        $this->add([
            'type' => 'FormPack\Element\Email',
            'name' => 'email',
            'options' => [
                'label' => 'E-Mail',
            ],
            'attributes' => [
                'required' => false,
            ],
        ]);
        
        $this->add([
            'type' => 'password',
            'name' => 'password',
            'options' => [
                'label' => 'Contraseña',
            ],
        ]);
        
        $this->add([
            'type' => 'password',
            'name' => 'password_confirm',
            'options' => [
                'label' => 'Repite la Contraseña',
            ],
        ]);
        
        $this->add([
            'type' => 'checkbox',
            'name' => 'active',
            'options' => [
                'label' => 'Activo',
            ],
            'attributes' => [
                'value' => '1',
            ],
        ]);
        
        $this->add([
            'type' => 'checkbox',
            'name' => 'is_superuser',
            'options' => [
                'label' => 'Super Usuario',
            ],
        ]);
        
        $this->add([
            'type' => 'select',
            'name' => 'admin_roles_id',
            'options' => [
                'label' => 'Rol',
                'value_options' => $adminRoleService->getOptionsList(),
                'empty_option'  => '[ Elige un Rol ]',
            ],
        ]);
    }
    
    
    public function getInputFilterSpecification()
    {
        return [
            [
                'name' => 'username',
                'required' => true,
                'validators' => [
                    'StringLength' => [
                        'name' => 'StringLength',
                        'break_chain_on_failure' => true,
                        'options' => [
                            'min' => 3,
                            'max' => 24,
                        ],
                    ],
                    'NoRecordExists' => [
                        'name' => 'Zend\Validator\Db\NoRecordExists',
                        'break_chain_on_failure' => true,
                        'options' => [
                            'table' => 'admin_users',
                            'field' => 'username',
                            'adapter' => $this->dbAdapter,
                            'exclude' => [
                                'field' => 'id',
                                'value' => $this->getId(),
                            ],
                        ],
                    ],
                ],
            ],
            
            [
                'name' => 'password',
                'required' => ($this->getId() == 0), // Required when new
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'break_chain_on_failure' => true,
                        'options' => [
                            'min' => 5,
                        ],
                    ],
                    [
                        'name' => 'Identical',
                        'options' => [
                            'token' => 'password_confirm',
                        ],
                    ],
                ],
            ],
            
            [
                'name' => 'password_confirm',
                'required' => false,
                'validators' => [
                    [
                        'name' => 'Identical',
                        'options' => [
                            'token' => 'password',
                        ],
                    ],
                ],
            ],
            
            [
                'name' => 'active',
                'required' => false,
            ],
            
            [
                'name' => 'is_superuser',
                'required' => false,
            ],
        ];
    }
    
    
    /**
     * @param integer $id
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    
    
    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
