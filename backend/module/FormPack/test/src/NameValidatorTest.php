<?php
namespace FormPack\Test;

use BaseTest\Helpers;
use FormPack\Validator\NameValidator;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Zend\Validator\AbstractValidator;

/**
 * @see AbstractHttpControllerTestCase
 * @package FormPack
 * @author Jaime G. Wong <j@jgwong.org>
 */
class NameValidatorTest extends AbstractHttpControllerTestCase
{
    use Helpers;
    
    /**
     * @var boolean
     */
    protected $traceError = true;
    
    
    public function setUp()
    {
        $this->setApplicationConfig(include(__DIR__ . '/../../../../config/application.config.php'));
        parent::setUp();
    }
    
    
    /**
     * @return NameValidator
     */
    public function getValidator()
    {
        return $this->getServiceManager()->get('ValidatorManager')->get(NameValidator::class);
    }
    
    
    public function test_instantiation()
    {
        $validator = $this->getValidator();
        $this->assertInstanceOf(AbstractValidator::class, $validator);
        $this->assertInstanceOf(NameValidator::class, $validator);
    }
    
    
    public function test_valid()
    {
        $validator = $this->getValidator();
        
        $names = [
            'Jorge',
            'Thalía', // Tilde
            'Jean-Pierre', // Dash
            'María del Pilar', // Spaces
            'Çéâêîôûàèùëïü', // "Special" characters
        ];
        
        foreach ($names as $name) {
            $this->assertTrue($validator->isValid($name), sprintf('Invalid name: %s', $name));
        }
    }
    
    
    public function test_invalid()
    {
        $validator = $this->getValidator();
        
        $names = [
            '123',
            'Pato$',
            'Ke$ha',
        ];
        
        foreach ($names as $name) {
            $this->assertFalse($validator->isValid($name), sprintf('Invalid name: %s', $name));
        }
    }
}
