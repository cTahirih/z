<?php
namespace FormPack\Validator;

use Zend\Validator\AbstractValidator;

/**
 * @package FormPack
 * @author Jaime G. Wong <j@jgwong.org>
 */
class NameValidator extends AbstractValidator
{
    /**
     * @var string
     */
    const INVALID = 'invalid';
    
    /**
     * @var array
     */
    protected $messageTemplates = [
        self::INVALID => 'No es un nombre válido',
    ];
    
    /**
     * @var array
     */
    protected $options = [
        'required' => true,
    ];
    
    
    /**
     * {@inheritDoc}
     */
    public function isValid($value, $context = null)
    {
        if (!is_string($value)) {
            $this->error(self::INVALID);
            return false;
        }
        
        $this->setValue($value);
        
        // Make a Locale-aware characters comparison, including whitespace
        // and dashes
        $pattern = '/[^\p{L} -]/u';
        $filteredValue = preg_replace($pattern, '', $value);
        
        if ($value !== $filteredValue) {
            $this->error(self::INVALID);
            return false;
        }
        
        return true;
    }
}
