<?php
namespace AppTest\Application\Command;

use AdminAuth2\Entity\AdminUser;
use App\Application\Command\GetUserForLoginCommand;
use App\Application\Command\GetUserForLoginCommandHandler;
use App\Application\Response\GetUserForLoginResponse;
use BaseTest\Helpers;
use Mockery;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

/**
 * @see AbstractControllerTestCase
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class GetUserForLoginCommandHandlerTest extends AbstractControllerTestCase
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
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
    
    
    /**
     * @return GetUserForLogin
     */
    public function getCommandHandler()
    {
        return $this->getServiceManager()->get(GetUserForLoginCommandHandler::class);
    }
    
    
    public function test_instantiation()
    {
        $handler = $this->getCommandHandler();
        $this->assertInstanceOf('DDD\Command\CommandHandlerInterface', $handler);
        $this->assertInstanceOf(GetUserForLoginCommandHandler::class, $handler);
    }
    
    
    public function test_handle_valid()
    {
        // Arrange
        $adminUserService = Mockery::mock('AdminAuth2\Service\AdminUserService')
            ->shouldReceive('getUserWithLogin')->once()
            ->with('jgwong', '123456')
            ->andReturn(new AdminUser())
            ->getMock();
        $this->setService('AdminAuth2\Service\AdminUserService', $adminUserService);
        
        // Act
        $handler = $this->getCommandHandler();
        $command = new GetUserForLoginCommand('jgwong', '123456');
        $response = $handler->handle($command);
        
        // Asssert
        $this->assertInstanceOf('App\Application\Dto\User', $response);
    }
    
    
    public function test_login_invalid()
    {
        // Arrange
        $adminUserService = Mockery::mock('AdminAuth2\Service\AdminUserService')
            ->shouldReceive('getUserWithLogin')->once()
            ->with('jgwong', '123456')
            ->andThrow('AdminAuth2\Exception\RuntimeException')
            ->getMock();
        $this->setService('AdminAuth2\Service\AdminUserService', $adminUserService);
        
        // Act
        $handler = $this->getCommandHandler();
        $command = new GetUserForLoginCommand('jgwong', '123456');
        $response = $handler->handle($command);
        
        // Asssert
        $this->assertNull($response);
    }
}
