<?php
/**
 * This file is part of AdminAuth2 Zend Framework 2 module.
 */

namespace AdminAuth2\Form;

use Zend\Form\Form;

class LoginForm extends Form
{
    public function __construct()
    {
        parent::__construct();
        
        $this->setAttribute('autocomplete','off');
        
        $this->add([
            'name' => 'username',
            'type' => 'FormPack\Element\Text',
            'options' => [
                'label' => 'Username',
            ],
            'attributes' => [
                'size' => 30,
            ],
        ]);
        
        $this->add([
            'name' => 'password',
            'type' => 'Password',
            'options' => [
                'label' => 'Password',
            ],
            'attributes' => [
                'size' => 30,
            ],
        ]);
        
        $this->add([
            'name' => 'csrf',
            'type' => 'Csrf',
            'options' => [
                'timeout' => 3600
            ],
        ]);
    }
}
