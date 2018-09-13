<?php
namespace FormPack\Element;

use InvalidArgumentException;
use Zend\Form\Element\Select;

/**
 * Builds a Select for a date's year part.
 *
 * Set `start` and `end` options.
 *
 * @see Text
 * @package FormPack
 * @author Jaime Wong <j@jgwong.org>
 */
class DateYear extends Select
{
    /**
     * {@inheritDoc}
     */
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        
        $this->setOptions([
            'empty_option' => 'Año',
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
        
        $start = $this->getOption('start');
        $end   = $this->getOption('end');
        
        if (is_null($start)) {
            throw new InvalidArgumentException(sprintf("Missing 'start' option for Year element %s", $name));
        }
        
        if (is_null($end)) {
            throw new InvalidArgumentException(sprintf("Missing 'end' option for Year element %s", $name));
        }
        
        $valueOptions = [];
        for ($i = $end; $i >= $start; $i--) {
            $year = (string) $i;
            $valueOptions[$year] = $year;
        }
        
        $this->setValueOptions($valueOptions);
        
        return $valueOptions;
    }
}
