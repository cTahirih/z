<?php
namespace AppTest\Infrastructure\Repository;

use App\Infrastructure\Repository\UserRepository;
use BaseTest\Helpers;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

/**
 * @see AbstractControllerTestCase
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class UserRepositoryTest extends AbstractControllerTestCase
{
    use Helpers;
    
    /**
     * @return void
     */
    public function setUp()
    {
        $this->markTestSkipped('Skipped due to schema mismatch');
        $configOverrides = [];
        
        $this->setApplicationConfig(ArrayUtils::merge(
            include 'config/application.config.php',
            include 'config/testing.config.php',
            $configOverrides
        ));
        
        parent::setUp();
    }
    
    
    /**
     * @return UserRepository
     */
    public function getRepository()
    {
        return $this->getServiceManager()->get(UserRepository::class);
    }
    
    
    public function test_instantiation()
    {
        $repository = $this->getRepository();
        $this->assertInstanceOf(UserRepository::class, $repository);
    }
    
    
    public function test_insertBatch()
    {
        // Arrange
        $this->truncateTable('users');
        
        $repository = $this->getRepository();
        $data = $this->loadFixture('users');
        
        // Act
        $repository->insertBatch($data);
        
        // Assert
        $this->assertTableCountIs(100, 'users');
    }
}
