<?php
namespace FormPack\Element;

use Zend\InputFilter\InputProviderInterface;
use Zend\StdLib\ArrayUtils;

/**
 * @see Text
 * @package FormPack
 * @author Jaime Wong <j@jgwong.org>
 */
class Email extends Text implements InputProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        
        $this->setAttributes([
            'minlength' => 5,
            'maxlength' => 255,
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
                    'name' => 'EmailAddress',
                ],
            ],
        ]);
    }
}
