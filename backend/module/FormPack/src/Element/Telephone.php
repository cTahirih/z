<?php
namespace FormPack\Element;

use Zend\InputFilter\InputProviderInterface;
use Zend\StdLib\ArrayUtils;

/**
 * @see Text
 * @package FormPack
 * @author Jaime Wong <j@jgwong.org>
 */
class Telephone extends Text implements InputProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        
        $this->setAttributes([
            'type'      => 'tel',
            'min'       => 0,
            'minlength' => 6,
            'maxlength' => 9,
        ]);
    }
    
    
    /**
     * {@inheritDoc}
     */
    public function getInputSpecification()
    {
        $parentSpec = parent::getInputSpecification();
        
        return ArrayUtils::merge($parentSpec, [
            'validators' => [
                [
                    'name' => 'Digits',
                ],
            ],
        ]);
    }
}
