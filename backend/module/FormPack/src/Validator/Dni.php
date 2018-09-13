<?php
namespace FormPack\Validator;

use Zend\Validator\AbstractValidator;

/**
 * DNI validator.
 *
 * Based on SUNAT's formal specification:
 * http://www2.sunat.gob.pe/pdt/pdtModulos/independientes/p695/TipoDoc.htm
 *
 * @package FormPack
 * @author Jaime G. Wong <j@jgwong.org>
 */
class Dni extends AbstractValidator
{
    /**
     * @var string
     */
    const INVALID = 'invalid';
    
    /**
     * @var array
     */
    protected $messageTemplates = [
        self::INVALID => 'DNI inválido',
    ];
    
    /**
     * @var array
     */
    protected $options = [
        'required' => true,
    ];
    
    
    /**
     * @param mixed $value
     * @param array $context
     * @return bool
     */
    public function isValid($value, $context = null)
    {
        $this->setValue($value);
        
        /**
         * SUNAT's DNI validation rules:
         *
         * - Should be numeric
         * - Should have exactly 8 characters
         */
        if (!preg_match('/\A[0-9]{8}\Z/', $value)) {
            $this->error(self::INVALID);
            return false;
        }
        
        return true;
    }
}
