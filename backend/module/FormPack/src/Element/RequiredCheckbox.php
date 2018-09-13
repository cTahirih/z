<?php
namespace FormPack\Element;

use Zend\Form\Element\Checkbox;
use Zend\InputFilter\InputProviderInterface;

/**
 * A checkbox for "I accept Terms of Service" cases, where the user is required
 * to check it to continue.
 * 
 * @see Checkbox
 * @package FormPack
 * @author Jaime Wong <j@jgwong.org>
 */
class RequiredCheckbox extends Checkbox implements InputProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function getInputSpecification()
    {
        return [
            'required' => true,
            'validators' => [
                [
                    'name' => 'FormPack\Validator\CheckboxChecked',
                ],
            ],
        ];
    }
}
