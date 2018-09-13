<?php
namespace AppTest\Form;

use App\Form\ReportForm;
use BaseTest\Helpers;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

/**
 * @see AbstractControllerTestCase
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class ReportFormTest extends AbstractControllerTestCase
{
    use Helpers;
    
    /**
     * @return void
     */
    public function setUp()
    {
        $configOverrides = [];
        
        $this->setApplicationConfig(ArrayUtils::merge(
            include 'config/application.config.php',
            include 'config/testing.config.php',
            $configOverrides
        ));
        
        parent::setUp();
    }
    
    
    /**
     * @return ReportForm
     */
    public function getForm()
    {
        return $this
            ->getServiceManager()
            ->get('FormElementManager')
            ->get(ReportForm::class);
    }
    
    
    public function test_instantiation()
    {
        $form = $this->getform();
        $this->assertInstanceOf('Zend\Form\Form', $form);
    }
}
