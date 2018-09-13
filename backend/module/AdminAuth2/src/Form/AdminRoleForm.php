<?php
/**
 * This file is part of AdminAuth2 Zend Framework 2 module.
 */

namespace AdminAuth2\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

/**
 * AdminRoleForm
 *
 * @see Form
 * @see InputFilterProviderInterface
 * @package AdminAuth2
 * @version v1.0.0
 * @author Jaime Wong <jaime.wong@nodosdigital.pe>
 */
class AdminRoleForm extends Form implements InputFilterProviderInterface
{
    protected $resourceService;
    
    
    public function __construct($resourceService)
    {
        parent::__construct();
        $this->resourceService = $resourceService;
        
        $this->add([
            'type' => 'FormPack\Element\Text',
            'name' => 'name',
            'options' => [
                'label' => 'Name',
            ],
        ]);
        
        $this->add([
            'type' => 'FormPack\Element\Textarea',
            'name' => 'description',
            'options' => [
                'label' => 'Description',
            ],
            'attributes' => [
                'cols'     => 40,
                'rows'     => 4,
                'required' => false,
            ],
        ]);
        
        $this->add([
            'type' => 'Checkbox',
            'name' => 'active',
            'options' => [
                'label' => 'Active',
            ],
            'attributes' => [
                'value' => '1',
            ],
        ]);
        
        $this->add([
            'type' => 'MultiCheckbox',
            'name' => 'resources',
            'options' => [
                'value_options' => $resourceService->getResourcesAsValueOptions(),
            ],
            'attributes' => [
                'class' => 'multicheckbox',
            ],
        ]);
    }
    
    
    public function getInputFilterSpecification()
    {
        return [
            'name' => [
                'required' => true,
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'max' => 50,
                        ],
                    ],
                ],
            ],
            
            'active' => [
                'required' => false,
            ],
            
            'description' => [
                'required' => false,
            ],
            
        ];
    }
}
