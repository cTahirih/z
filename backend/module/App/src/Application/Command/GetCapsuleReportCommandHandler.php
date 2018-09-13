<?php
namespace App\Application\Command;

use App\Application\Dto\Report\CapsulesAverageByUser;
use App\Application\Dto\Report\CapsulesQuantityByMonth;
use App\Application\Dto\Report\CapsulesTotal;
use App\Domain\ValueObject\DateRange;
use App\Infrastructure\Repository\CapsuleRepository;
use DDD\Command\Command;
use DDD\Command\CommandHandlerInterface;

/**
 * @see CommandHandler
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class GetCapsuleReportCommandHandler implements CommandHandlerInterface
{
    /**
     * @var CapsuleRepository
     */
    protected $repository;
    
    
    /**
     * @param CapsuleRepository $repository
     * @return void
     */
    public function __construct(
        CapsuleRepository $repository
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
     * @return CapsulesTotal
     */
    public function handleTotal(Command $command)
    {
        $data = $this->repository->getTotal($this->getDateRange($command));
        return new CapsulesTotal($data);
    }
    
    
    /**
     * @param Command $command
     * @return CapsulesAverageByUser
     */
    public function handleAverageByUser(Command $command)
    {
        $data = $this->repository->getAverageByUser($this->getDateRange($command));
        return new CapsulesAverageByUser($data);
    }
    
    
    /**
     * @param Command $command
     * @return CapsulesQuantityByMonth
     */
    public function handleQuantityByMonth(Command $command)
    {
        $data = $this->repository->getQuantityByMonth($this->getDateRange($command));
        return new CapsulesQuantityByMonth($data);
    }
}
