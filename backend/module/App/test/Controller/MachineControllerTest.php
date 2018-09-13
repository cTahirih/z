<?php
namespace AppTest\Controller;

use App\Controller\MachineController;
use BaseTest\Helpers;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * @see AbstractHttpControllerTestCase
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class MachineControllerTest extends AbstractHttpControllerTestCase
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
            ->get('App\Controller\MachineController');
        $this->assertInstanceOf('Zend\Mvc\Controller\AbstractActionController', $controller);
    }
    
    
    public function test_machines_total()
    {
        $dateRange = '?start_year=2018&start_month=01&end_year=2018&end_month=12';
        $this->dispatch('/reports/machines/machines-total' . $dateRange);
        
        $this->assertResponseStatusCode(200);
        $this->assertResponseIsJson();
        
        $response = $this->getDecodedJsonResponse();
        $this->assertArrayHasKey('all', $response);
        $this->assertArrayHasKey('gold', $response);
        $this->assertArrayHasKey('platinum', $response);
    }
    
    
    public function test_machines_average_by_user()
    {
        $dateRange = '?start_year=2018&start_month=01&end_year=2018&end_month=12';
        $this->dispatch('/reports/machines/machines-average-by-user' . $dateRange);
        
        $this->assertResponseStatusCode(200);
        $this->assertResponseIsJson();
        
        $response = $this->getDecodedJsonResponse();
        $this->assertArrayHasKey('all', $response);
        $this->assertArrayHasKey('gold', $response);
        $this->assertArrayHasKey('platinum', $response);
    }
    
    
    public function test_machines_quantity_by_month()
    {
        $dateRange = '?start_year=2018&start_month=01&end_year=2018&end_month=12';
        $this->dispatch('/reports/machines/machines-quantity-by-month' . $dateRange);
        
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
    
    
    public function test_machines_acquisition_average_by_user()
    {
        $dateRange = '?start_year=2018&start_month=01&end_year=2018&end_month=12';
        $this->dispatch('/reports/machines/machines-acquisition-average-by-user' . $dateRange);
        
        $this->assertResponseStatusCode(200);
        $this->assertResponseIsJson();
        
        $response = $this->getDecodedJsonResponse();
        $this->assertArrayHasKey('all', $response);
        $this->assertArrayHasKey('gold', $response);
        $this->assertArrayHasKey('platinum', $response);
    }
    
    
    public function test_machines_best_month()
    {
        $dateRange = '?start_year=2018&start_month=01&end_year=2018&end_month=12';
        $this->dispatch('/reports/machines/machines-best-month' . $dateRange);
        
        $this->assertResponseStatusCode(200);
        $this->assertResponseIsJson();
        
        $response = $this->getDecodedJsonResponse();
        $this->assertArrayHasKey('month', $response);
        $this->assertArrayHasKey('year', $response);
    }
}
