<?php
namespace App\Application\Command;

use App\Application\Dto\Report\ClaimsAcquisitionAverageByUser;
use App\Application\Dto\Report\ClaimsAverageByUser;
use App\Application\Dto\Report\ClaimsBestMonth;
use App\Application\Dto\Report\ClaimsQuantityByMonth;
use App\Application\Dto\Report\ClaimsTotal;
use App\Domain\ValueObject\DateRange;
use App\Infrastructure\Repository\ClaimRepository;
use DDD\Command\Command;
use DDD\Command\CommandHandlerInterface;

/**
 * @see CommandHandler
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class GetClaimReportCommandHandler implements CommandHandlerInterface
{
    /**
     * @var ClaimRepository
     */
    protected $repository;
    
    
    /**
     * @param ClaimRepository $repository
     * @return void
     */
    public function __construct(
        ClaimRepository $repository
    ) {
        $this->repository = $repository;
    }
    
    
    /**
     * @param Command $command
     * @return mixed
     */
    public function handle(Command $command)
    {
        // Call the appropiate Report handler method
        $handler = 'handle' . $command->report;
        return $this->$handler($command);
    }
    
    
    /**
     * Builds a DateRange object from the Command's parameters.
     *
     * @param Command $command
     * @return DateRange
     */
    public function getDateRange(Command $command)
    {
        return new DateRange(
            $command->startMonth,
            $command->startYear,
            $command->endMonth,
            $command->endYear
        );
    }
    
    
    /**
     * @param Command $command
     * @return ClaimsTotal
     */
    public function handleTotal(Command $command)
    {
        $data = $this->repository->getTotal($this->getDateRange($command));
        return new ClaimsTotal($data);
    }
    
    
    /**
     * @param Command $command
     * @return ClaimsAverageByUser
     */
    public function handleAverageByUser(Command $command)
    {
        $data = $this->repository->getAverageByUser($this->getDateRange($command));
        return new ClaimsAverageByUser($data);
    }
    
    
    /**
     * @param Command $command
     * @return ClaimsQuantityByMonth
     */
    public function handleQuantityByMonth(Command $command)
    {
        $data = $this->repository->getQuantityByMonth($this->getDateRange($command));
        return new ClaimsQuantityByMonth($data);
    }
    
    
    /**
     * @param Command $command
     * @return ClaimsAcquisitionAverageByUser
     */
    public function handleAcquisitionAverageByUser(Command $command)
    {
        $data = $this->repository->getAcquisitionAverageByUser($this->getDateRange($command));
        return new ClaimsAcquisitionAverageByUser($data);
    }
}
