<?php
namespace AppTest\Controller;

use App\Controller\CapsuleController;
use BaseTest\Helpers;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * @see AbstractHttpControllerTestCase
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class CapsuleControllerTest extends AbstractHttpControllerTestCase
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
        
        // Force `show_backend_template`
        $this->setConfig(function ($config) {
            $config['show_backend_template'] = true;
            return $config;
        });
        
        // "Login" User
        $session = $this->getServiceManager()->get('App\Infrastructure\Session');
        $session['user'] = 1;
    }
    
    
    public function test_controller()
    {
        $controller = $this
            ->getServiceManager()
            ->get('ControllerManager')
            ->get('App\Controller\CapsuleController');
        $this->assertInstanceOf('Zend\Mvc\Controller\AbstractActionController', $controller);
    }
    
    
    public function test_capsules_total()
    {
        $dateRange = '?start_year=2018&start_month=01&end_year=2018&end_month=12';
        $this->dispatch('/reports/capsules/capsules-total' . $dateRange);
        
        $this->assertResponseStatusCode(200);
        $this->assertResponseIsJson();
        
        $response = $this->getDecodedJsonResponse();
        $this->assertArrayHasKey('all', $response);
        $this->assertArrayHasKey('gold', $response);
        $this->assertArrayHasKey('platinum', $response);
    }
    
    
    public function test_capsules_average_by_user()
    {
        $dateRange = '?start_year=2018&start_month=01&end_year=2018&end_month=12';
        $this->dispatch('/reports/capsules/capsules-average-by-user' . $dateRange);
        
        $this->assertResponseStatusCode(200);
        $this->assertResponseIsJson();
        
        $response = $this->getDecodedJsonResponse();
        $this->assertArrayHasKey('all', $response);
        $this->assertArrayHasKey('gold', $response);
        $this->assertArrayHasKey('platinum', $response);
    }
    
    
    public function test_capsules_average_by_user_should_fail_on_missing_date_range()
    {
        $this->dispatch('/reports/capsules/capsules-average-by-user');
        
        $this->assertResponseStatusCode(400);
    }
    
    
    public function test_capsules_quantity_by_month()
    {
        $dateRange = '?start_year=2018&start_month=01&end_year=2018&end_month=12';
        $this->dispatch('/reports/capsules/capsules-quantity-by-month' . $dateRange);
        
        $this->assertResponseStatusCode(200);
        $this->assertResponseIsJson();
        
        $response = $this->getDecodedJsonResponse();
        $this->assertIsArray($response);
        
        foreach ($response as $row) {
            $this->assertArrayHasKey('month', $row);
            $this->assertArrayHasKey('year', $row);
            
            $this->assertArrayHasKey('total', $row);
            $this->assertArrayHasKey('all', $row['total']);
            $this->assertArrayHasKey('gold', $row['total']);
            $this->assertArrayHasKey('platinum', $row['total']);
            
            $this->assertArrayHasKey('average', $row);
            $this->assertArrayHasKey('gold', $row['average']);
            $this->assertArrayHasKey('platinum', $row['average']);
        }
    }
    
    
    public function test_capsules_quantity_by_month_should_fail_on_missing_date_range()
    {
        $this->dispatch('/reports/capsules/capsules-quantity-by-month');
        
        $this->assertResponseStatusCode(400);
    }
    
    
    public function test_capsules_total_as_csv()
    {
        $dateRange = '?start_year=2018&start_month=01&end_year=2018&end_month=12&export=1';
        $this->dispatch('/reports/capsules/capsules-total' . $dateRange);
        
        $this->assertResponseStatusCode(200);
        $this->assertEquals('text/csv', $this->getResponse()->getHeaders()->get('Content-Type')->getMediaType());
    }
    
    
}
