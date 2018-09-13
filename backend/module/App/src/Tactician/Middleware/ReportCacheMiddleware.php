<?php
namespace App\Tactician\Middleware;

use App\Application\Service\ReportCacheService;
use League\Tactician\Middleware;

/**
 * @see Middleware
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class ReportCacheMiddleware implements Middleware
{
    /**
     * @var ReportCacheService
     */
    protected $reportCacheService;
    
    
    public function __construct(
        ReportCacheService $reportCacheService
    ) {
        $this->reportCacheService = $reportCacheService;
    }
    
    
    /**
     * @param object   $command
     * @param callable $next
     *
     * @return mixed
     */
    public function execute($command, callable $next)
    {
        // Prepare a whitelst of cacheable Report commands
        $whitelist = [
            'App\Application\Command\GetCapsuleReportCommand',
            'App\Application\Command\GetMachineReportCommand',
            'App\Application\Command\GetClaimReportCommand',
        ];
        
        // Ignore if non-Report Command
        if (!in_array(get_class($command), $whitelist)) {
            return $next($command);
        }
        
        // Fetch from cache
        $reportCacheService = $this->reportCacheService;
        $report = $command->section . '-' . $command->report;
        $cached = $reportCacheService->get($report, $command->parameters);
        
        // Return cached content
        if (!is_null($cached)) {
            return $cached;
        }
        
        // Not in cache
        $data = $next($command);
        
        $reportCacheService->save($report, $command->parameters, $data);
        
        return $data;
    }
}
