<?php
namespace FormPack\Element;

use Zend\InputFilter\InputProviderInterface;
use Zend\StdLib\ArrayUtils;

/**
 * @see Text
 * @package FormPack
 * @author Jaime Wong <j@jgwong.org>
 */
class Dni extends Text implements InputProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function __construct($name = null, $options = array())
    {
        $this->setAttributes([
            'type'      => 'text',
            'min'       => 0,
            'minlength' => 8,
            'maxlength' => 8,
        ]);
        parent::__construct($name, $options);
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
                    'name' => 'FormPack\Validator\Dni',
                ],
            ],
        ]);
    }
}
