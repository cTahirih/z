<?php
namespace App\Controller;

use App\Application\Command\GetMachineReportCommand;
use App\Domain\Specification\SpecificationInterface;
use Zend\InputFilter\InputFilter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

/**
 * @see AbstractActionController
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class MachineController extends AbstractActionController
{
    use DateRangeTrait;
    use ReportResponseTrait;
    
    /**
     * @var Container
     */
    protected $session;
    
    /**
     * @var InputFilter
     */
    protected $dateRangeInputFilter;
    
    /**
     * @var SpecificationInterface
     */
    protected $validDateRangeSpecification;
    
    
    /**
     * @param InputFilter $dateRangeInputFilter
     * @param SpecificationInterface $validDateRangeSpecification
     * @return void
     */
    public function __construct(
        Container $session,
        InputFilter $dateRangeInputFilter,
        SpecificationInterface $validDateRangeSpecification
    ) {
        $this->session                     = $session;
        $this->dateRangeInputFilter        = $dateRangeInputFilter;
        $this->validDateRangeSpecification = $validDateRangeSpecification;
    }
    
    
    /**
     * @return \Zend\View\Model\JsonModel|\Zend\Http\Response
     */
    public function machinesTotalAction()
    {
        if (!$this->session->isUserLoggedIn()) {
            return $this->getResponse()->setStatusCode(401);
        }
        
        if ($this->dateRangeIsValid() == false) {
            return $this->getResponse()->setStatusCode(400);
        }
        
        $dateRangeParameters = $this->getDateRangeParameters();
        
        $command = new GetMachineReportCommand(
            'Total',
            $dateRangeParameters
        );
        $report = $this->commandBus()->handle($command);
        
        return $this->reportResponse($report);
    }
    
    
    /**
     * @return \Zend\View\Model\JsonModel|\Zend\Http\Response
     */
    public function machinesAverageByUserAction()
    {
        if (!$this->session->isUserLoggedIn()) {
            return $this->getResponse()->setStatusCode(401);
        }
        
        if ($this->dateRangeIsValid() == false) {
            return $this->getResponse()->setStatusCode(400);
        }
        
        $dateRangeParameters = $this->getDateRangeParameters();
        
        $command = new GetMachineReportCommand(
            'AverageByUser',
            $dateRangeParameters
        );
        $report = $this->commandBus()->handle($command);
        
        return $this->reportResponse($report);
    }
    
    
    /**
     * @return \Zend\View\Model\JsonModel|\Zend\Http\Response
     */
    public function machinesQuantityByMonthAction()
    {
        if (!$this->session->isUserLoggedIn()) {
            return $this->getResponse()->setStatusCode(401);
        }
        
        if ($this->dateRangeIsValid() == false) {
            return $this->getResponse()->setStatusCode(400);
        }
        
        $dateRangeParameters = $this->getDateRangeParameters();
        
        $command = new GetMachineReportCommand(
            'QuantityByMonth',
            $dateRangeParameters
        );
        $report = $this->commandBus()->handle($command);
        
        return $this->reportResponse($report);
    }
    
    
    /**
     * @return \Zend\View\Model\JsonModel|\Zend\Http\Response
     */
    public function machinesAcquisitionAverageByUserAction()
    {
        if (!$this->session->isUserLoggedIn()) {
            return $this->getResponse()->setStatusCode(401);
        }
        
        if ($this->dateRangeIsValid() == false) {
            return $this->getResponse()->setStatusCode(400);
        }
        
        $dateRangeParameters = $this->getDateRangeParameters();
        
        $command = new GetMachineReportCommand(
            'AcquisitionAverageByUser',
            $dateRangeParameters
        );
        $report = $this->commandBus()->handle($command);
        
        return $this->reportResponse($report);
    }
    
    
    /**
     * @return \Zend\View\Model\JsonModel|\Zend\Http\Response
     */
    public function machinesBestMonthAction()
    {
        if (!$this->session->isUserLoggedIn()) {
            return $this->getResponse()->setStatusCode(401);
        }
        
        if ($this->dateRangeIsValid() == false) {
            return $this->getResponse()->setStatusCode(400);
        }
        
        $dateRangeParameters = $this->getDateRangeParameters();
        
        $command = new GetMachineReportCommand(
            'BestMonth',
            $dateRangeParameters
        );
        $report = $this->commandBus()->handle($command);
        
        return $this->reportResponse($report);
    }
}
