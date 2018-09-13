<?php
namespace FormPack\Element;

use Zend\Form\Element\Select;

/**
 * Builds a Select for a date's month part.
 *
 * If you pass a `use_numbers` option will use numbers instead of month names.
 *
 * @see Text
 * @package FormPack
 * @author Jaime Wong <j@jgwong.org>
 */
class DateMonth extends Select
{
    /**
     * @var array
     */
    private $monthNames = [
        '01' => 'Enero',
        '02' => 'Febrero',
        '03' => 'Marzo',
        '04' => 'Abril',
        '05' => 'Mayo',
        '06' => 'Junio',
        '07' => 'Julio',
        '08' => 'Agosto',
        '09' => 'Setiembre',
        '10' => 'Octubre',
        '11' => 'Noviembre',
        '12' => 'Diciembre',
    ];
    
    
    /**
     * {@inheritDoc}
     */
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
        
        $this->setOptions([
            'empty_option' => 'Mes',
        ]);
    }
    
    
    /**
     * {@inheritDoc}
     */
    public function getValueOptions()
    {
        $valueOptions = parent::getValueOptions();
        
        if (!empty($valueOptions) && !is_null($valueOptions)) {
            return $valueOptions;
        }
        
        $useNumbers = $this->getOption('use_numbers');
        if ($useNumbers === true) {
            $useNumbers = true;
        }
        
        $valueOptions = [];
        for ($i = 1; $i <= 12; $i++) {
            $key = str_pad($i, 2, '0', STR_PAD_LEFT);
            
            $value = $key;
            if ($useNumbers == false) {
                $value = $this->monthNames[$key];
            }
            
            $valueOptions[$key] = $value;
        }
        
        $this->setValueOptions($valueOptions);
        
        return $valueOptions;
    }
}
