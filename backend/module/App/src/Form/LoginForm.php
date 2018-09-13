<?php
namespace App\Form;

use Zend\Form\Form;

/**
 * @see Form
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class LoginForm extends Form
{
    /**
     * @return void
     */
    public function init()
    {
        $this->setAttribute('autocomplete', 'off');
        
        $this->add([
            'type' => 'Text',
            'name' => 'username',
            'options' => [
                'label' => 'Nombre de Usuario',
            ],
        ]);
        
        $this->add([
            'type' => 'Password',
            'name' => 'password',
            'options' => [
                'label' => 'Contraseña',
            ],
        ]);
        
        $this->add([
            'type' => 'Csrf',
            'name' => 'csrf',
        ]);
    }
}
