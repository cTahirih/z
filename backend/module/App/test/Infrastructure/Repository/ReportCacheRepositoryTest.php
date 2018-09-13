<?php
namespace AppTest\Infrastructure\Repository;

use App\Infrastructure\Repository\ReportCacheRepository;
use BaseTest\Helpers;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

/**
 * @see AbstractControllerTestCase
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class ReportCacheRepositoryTest extends AbstractControllerTestCase
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
     * @return ReportCacheRepository
     */
    public function getRepository()
    {
        return $this->getServiceManager()->get(ReportCacheRepository::class);
    }
    
    
    public function test_instantiation()
    {
        $repository = $this->getRepository();
        $this->assertInstanceOf(ReportCacheRepository::class, $repository);
    }
    
    
    public function test_save()
    {
        $this->truncateTable('reports_cache');
        
        $repository = $this->getRepository();
        
        $data = [
            'track'  => 'Lionheart',
            'artist' => 'Emancipator',
            'album'  => 'Soon It Will Be Cold Enough',
        ];
        
        $repository->save('test', 'params', $data);
        
        $this->assertTableCountIs(1, 'reports_cache');
    }
    
    
    public function test_get()
    {
        $this->truncateTable('reports_cache');
        
        $repository = $this->getRepository();
        
        $data = [
            'track'  => 'The Darkest Evening of the Year',
            'artist' => 'Emancipator',
            'album'  => 'Soon It Will Be Cold Enough',
        ];
        
        $repository->save('test', 'params', $data);
        
        $cachedData = $repository->get('test', 'params');
        
        $this->assertEquals($data, $cachedData);
   }
}
