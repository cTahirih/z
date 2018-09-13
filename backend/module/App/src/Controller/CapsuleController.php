<?php
namespace App\Controller;

use App\Application\Command\GetCapsuleReportCommand;
use App\Domain\Specification\SpecificationInterface;
use Zend\InputFilter\InputFilter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

/**
 * @see AbstractActionController
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class CapsuleController extends AbstractActionController
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
    public function capsulesTotalAction()
    {
        if (!$this->session->isUserLoggedIn()) {
            return $this->getResponse()->setStatusCode(401);
        }
        
        if ($this->dateRangeIsValid() == false) {
            return $this->getResponse()->setStatusCode(400);
        }
        
        $dateRangeParameters = $this->getDateRangeParameters();
        
        $command = new GetCapsuleReportCommand(
            'Total',
            $dateRangeParameters
        );
        $report = $this->commandBus()->handle($command);
        
        return $this->reportResponse($report);
    }
    
    
    /**
     * @return \Zend\View\Model\JsonModel|\Zend\Http\Response
     */
    public function capsulesAverageByUserAction()
    {
        if (!$this->session->isUserLoggedIn()) {
            return $this->getResponse()->setStatusCode(401);
        }
        
        if ($this->dateRangeIsValid() == false) {
            return $this->getResponse()->setStatusCode(400);
        }
        
        $dateRangeParameters = $this->getDateRangeParameters();
        
        $command = new GetCapsuleReportCommand(
            'AverageByUser',
            $dateRangeParameters
        );
        $report = $this->commandBus()->handle($command);
        
        return $this->reportResponse($report);
    }
    
    
    /**
     * @return \Zend\View\Model\JsonModel|\Zend\Http\Response
     */
    public function capsulesQuantityByMonthAction()
    {
        if (!$this->session->isUserLoggedIn()) {
            return $this->getResponse()->setStatusCode(401);
        }
        
        if ($this->dateRangeIsValid() == false) {
            return $this->getResponse()->setStatusCode(400);
        }
        
        $dateRangeParameters = $this->getDateRangeParameters();
        
        $command = new GetCapsuleReportCommand(
            'QuantityByMonth',
            $dateRangeParameters
        );
        $report = $this->commandBus()->handle($command);
        
        return $this->reportResponse($report);
    }
}
