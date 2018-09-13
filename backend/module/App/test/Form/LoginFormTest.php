<?php
namespace AppTest\Form;

use App\Form\LoginForm;
use BaseTest\Helpers;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

/**
 * @see AbstractControllerTestCase
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class LoginFormTest extends AbstractControllerTestCase
{
    use Helpers;
    
    /**
     * @return void
     */
    public function setUp()
    {
        $configOverrides = [];
        
        $this->setApplicationConfig(ArrayUtils::merge(
            include __DIR__ . '/../../../../config/application.config.php',
            include __DIR__ . '/../../../../config/testing.config.php',
            $configOverrides
        ));
        
        parent::setUp();
    }
    
    
    /**
     * @return LoginForm
     */
    public function getForm()
    {
        return $this
            ->getServiceManager()
            ->get('FormElementManager')
            ->get(LoginForm::class);
    }
    
    
    public function test_instantiation()
    {
        $form = $this->getform();
        $this->assertInstanceOf('Zend\Form\Form', $form);
    }
}
