<?php
namespace FormPack\Element;

use Zend\InputFilter\InputProviderInterface;
use Zend\StdLib\ArrayUtils;

/**
 * @see Text
 * @package FormPack
 * @author Jaime Wong <j@jgwong.org>
 */
class Number extends Text implements InputProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        
        $this->setAttributes([
            'type'      => 'tel',
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
                    'name' => 'Digits',
                ],
            ],
        ]);
    }
}
