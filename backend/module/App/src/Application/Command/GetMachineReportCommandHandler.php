<?php
namespace App\Application\Command;

use App\Application\Dto\Report\MachinesAcquisitionAverageByUser;
use App\Application\Dto\Report\MachinesAverageByUser;
use App\Application\Dto\Report\MachinesBestMonth;
use App\Application\Dto\Report\MachinesQuantityByMonth;
use App\Application\Dto\Report\MachinesTotal;
use App\Domain\ValueObject\DateRange;
use App\Infrastructure\Repository\MachineRepository;
use DDD\Command\Command;
use DDD\Command\CommandHandlerInterface;

/**
 * @see CommandHandler
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class GetMachineReportCommandHandler implements CommandHandlerInterface
{
    /**
     * @var MachineRepository
     */
    protected $repository;
    
    
    /**
     * @param MachineRepository $repository
     * @return void
     */
    public function __construct(
        MachineRepository $repository
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
     * @return MachinesTotal
     */
    public function handleTotal(Command $command)
    {
        $data = $this->repository->getTotal($this->getDateRange($command));
        return new MachinesTotal($data);
    }
    
    
    /**
     * @param Command $command
     * @return MachinesAverageByUser
     */
    public function handleAverageByUser(Command $command)
    {
        $data = $this->repository->getAverageByUser($this->getDateRange($command));
        return new MachinesAverageByUser($data);
    }
    
    
    /**
     * @param Command $command
     * @return MachinesQuantityByMonth
     */
    public function handleQuantityByMonth(Command $command)
    {
        $data = $this->repository->getQuantityByMonth($this->getDateRange($command));
        return new MachinesQuantityByMonth($data);
    }
    
    
    /**
     * @param Command $command
     * @return MachinesAcquisitionAverageByUser
     */
    public function handleAcquisitionAverageByUser(Command $command)
    {
        $data = $this->repository->getAcquisitionAverageByUser($this->getDateRange($command));
        return new MachinesAcquisitionAverageByUser($data);
    }
    
    
    /**
     * @param Command $command
     * @return MachinesBestMonth
     */
    public function handleBestMonth(Command $command)
    {
        $data = $this->repository->getBestMonth($this->getDateRange($command));
        return new MachinesBestMonth($data);
    }
}
