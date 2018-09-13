<?php
namespace FormPack\Element;

use Zend\InputFilter\InputProviderInterface;
use Zend\StdLib\ArrayUtils;

/**
 * A Text element with a FormPack\Validator\DateValidator validator attached.
 * You can pass options to DateValidator via the `date_validator` option.
 * See DateValidator for information on options.
 *
 * @see Text
 * @package FormPack
 * @author Jaime Wong <j@jgwong.org>
 */
class Date extends Text implements InputProviderInterface
{
    /**
     * @return array
     */
    public function getInputSpecification()
    {
        $parentSpec = parent::getInputSpecification();
        
        return ArrayUtils::merge($parentSpec, [
            'validators' => [
                [
                    'name'    => 'FormPack\Validator\DateValidator',
                    'options' => $this->getOption('date_validator'),
                ],
            ],
        ]);
    }
}
