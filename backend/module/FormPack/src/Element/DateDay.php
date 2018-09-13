<?php
namespace FormPack\Element;

use Zend\Form\Element\Select;

/**
 * Builds a Select for a date's day part.
 *
 * @see Text
 * @package FormPack
 * @author Jaime Wong <j@jgwong.org>
 */
class DateDay extends Select
{
    /**
     * {@inheritDoc}
     */
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        
        $this->setOptions([
            'value_options' => $valueOptions,
            'empty_option' => 'Día',
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
        
        $valueOptions = [];
        for ($i = 1; $i <= 31; $i++) {
            $valueOptions[str_pad($i, 2, '0', STR_PAD_LEFT)] = (string) $i;
        }
        
        $this->setValueOptions($valueOptions);
        
        return $valueOptions;
    }
}
