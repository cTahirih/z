<?php
namespace App\Application\Service;

use App\Infrastructure\Repository\ReportCacheRepository;

/**
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class ReportCacheService
{
    /**
     * @var ReportCacheRepository
     */
    protected $reportCacheRepository;
    
    
    /**
     * @return void
     */
    public function __construct(
        ReportCacheRepository $reportCacheRepository
    ) {
        $this->reportCacheRepository = $reportCacheRepository;
    }
    
    
    /**
     * @param string $report
     * @param array $parameters
     * @param mixed $content
     * @return void
     */
    public function save(string $report, array $parameters, $content)
    {
        $this->reportCacheRepository->save($report, serialize($parameters), $content);
    }
    
    
    /**
     * @param string $report
     * @param array $parameters
     * @return mixed
     */
    public function get(string $report, array $parameters)
    {
        return $this->reportCacheRepository->get($report, serialize($parameters));
    }
}
