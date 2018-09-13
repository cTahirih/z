<?php
namespace FormPack\Validator;

use Zend\Validator\AbstractValidator;

/**
 * CheckboxChecked validator
 *
 * Returns valid if the Checkbox is considered "checked" by comparing the
 * value of the checkbox with the option "checkedValue".
 *
 * @package FormPack
 * @author Jaime G. Wong <j@jgwong.org>
 */
class CheckboxChecked extends AbstractValidator
{
    const UNCHECKED = 'unchecked';
    
    protected $messageTemplates = [
        self::UNCHECKED => 'Debes marcar la casilla',
    ];
    
    protected $options = [
        'checkedValue' => '1', // Same as `Zend\Form\Element\Checkbox`'s default
        'required'     => true,
    ];
    
    
    /**
     * @param string $value
     * @return bool
     */
    public function isValid($value)
    {
        $this->setValue($value);
        
        if ($value != $this->getOption('checkedValue') && $this->getOption('required') === true) {
            $this->error(self::UNCHECKED);
            return false;
            
        }
        
        return true;
    }
}
