<?php
namespace FormPack\Validator;

use RuntimeException;
use Zend\Validator\AbstractValidator;

/**
 * Validates a Peruvian Document number field where the type of document is
 * picked in a companion element (usually a Select). The name of this Element
 * should be defined in the `type_element` option.
 *
 * The possible document type values are:
 *
 * - `dni` - DNI
 * - `ce` - Carnet de Extranjería
 * - `cd` - Carnet de Diplomático
 * - `cm` - Carnet de Militar
 * - `psp' - Pasaporte
 *
 * Validation rules are based on this document by SUNAT (as of 2017-06-26):
 * http://www2.sunat.gob.pe/pdt/pdtModulos/independientes/p695/TipoDoc.htm
 *
 * @package FormPack
 * @author Jaime G. Wong <j@jgwong.org>
 */
class PeruvianDocument extends AbstractValidator
{
    /**
     * @var string
     */
    const INVALID = 'invalid';
    
    /**
     * @var array
     */
    protected $messageTemplates = [
        self::INVALID => 'Número de Documento inválido',
    ];
    
    /**
     * @var array
     */
    protected $options = [
        'type_element' => null,
        'required'     => true,
    ];
    
    
    /**
     * {@inheritDoc}
     */
    public function isValid($value, $context = null)
    {
        $this->setValue($value);
        
        $typeElement = $this->options['type_element'];
        
        if (is_null($typeElement)) {
            throw new RuntimeException('Undefined type_element.');
        }
        
        $type  = $context[$typeElement];
        $valid = false;
        
        if ($type == 'dni') {
            $valid = $this->isValidDni($value);
            
        } elseif ($type == 'ce') {
            $valid = $this->isValidCarnetDeExtranjeria($value);
            
        } elseif ($type == 'psp') {
            $valid = $this->isValidPasaporte($value);
        
        } elseif ($type == 'cd') {
            $valid = $this->isValidOther($value);
        
        } elseif ($type == 'cm') {
            $valid = $this->isValidOther($value);
        }
        
        if ($valid == false) {
            $this->error(self::INVALID);
            return false;
        }
        
        return true;
    }
    
    
    /**
     * @param integer $value
     * @return boolean
     */
    public function isValidDni($value)
    {
        return preg_match('/\A[0-9]{8}\Z/', $value);
    }
    
    
    /**
     * @param string $value
     * @return boolean
     */
    public function isValidCarnetDeExtranjeria($value)
    {
        return preg_match('/\A[A-Z0-9]{8,12}\Z/', strtoupper($value));
    }
    
    
    /**
     * @param string $value
     * @return boolean
     */
    public function isValidPasaporte($value)
    {
        return preg_match('/\A[A-Z0-9]{8,12}\Z/', strtoupper($value));
    }
    
    
    /**
     * @param string $value
     * @return boolean
     */
    public function isValidOther($value)
    {
        return preg_match('/\A[A-Z0-9]{8,15}\Z/', strtoupper($value));
    }
}
