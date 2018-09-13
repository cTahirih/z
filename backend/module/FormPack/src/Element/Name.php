<?php
namespace FormPack\Element;

use Zend\InputFilter\InputProviderInterface;
use Zend\StdLib\ArrayUtils;

/**
 * Has built-in input and sensible defaults for a person name field.
 *
 * @see Text
 * @package FormPack
 * @author Jaime Wong <j@jgwong.org>
 */
class Name extends Text implements InputProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        
        $this->setAttributes([
            'minlength' => 2,
            'maxlength' => 70,
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
                    'name' => 'FormPack\Validator\NameValidator',
                ],
            ],
        ]);
    }
}
