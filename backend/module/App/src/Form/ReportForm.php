<?php
namespace App\Form;

use Zend\Form\Form;

/**
 * @see Form
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class ReportForm extends Form
{
    /**
     * @return void
     */
    public function init()
    {
        $this->setAttribute('autocomplete', 'off');
        
        $this->add([
            'type' => 'Text',
            'name' => 'start_date',
            'options' => [
                'label' => 'Fecha de Inicio',
            ],
        ]);
        
        $this->add([
            'type' => 'Text',
            'name' => 'end_date',
            'options' => [
                'label' => 'Fecha de Fin',
            ],
        ]);
        
        $this->add([
            'type' => 'Radio',
            'name' => 'segment',
            'options' => [
                'label' => 'Tipo de Usuario',
                'value_options' => [
                    'all'      => 'Todos',
                    'gold'     => 'Oro',
                    'platinum' => 'Platino',
                ],
            ],
        ]);
    }
}
