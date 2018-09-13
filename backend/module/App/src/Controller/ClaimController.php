<?php
namespace App\Controller;

use App\Application\Command\GetClaimReportCommand;
use App\Domain\Specification\SpecificationInterface;
use Zend\InputFilter\InputFilter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

/**
 * @see AbstractActionController
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class ClaimController extends AbstractActionController
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
    public function claimsTotalAction()
    {
        if (!$this->session->isUserLoggedIn()) {
            return $this->getResponse()->setStatusCode(401);
        }
        
        if ($this->dateRangeIsValid() == false) {
            return $this->getResponse()->setStatusCode(400);
        }
        
        $dateRangeParameters = $this->getDateRangeParameters();
        
        $command = new getClaimReportCommand(
            'Total',
            $dateRangeParameters
        );
        $report = $this->commandBus()->handle($command);
        
        return $this->reportResponse($report);
    }
    
    
    /**
     * @return \Zend\View\Model\JsonModel|\Zend\Http\Response
     */
    public function claimsAverageByUserAction()
    {
        if (!$this->session->isUserLoggedIn()) {
            return $this->getResponse()->setStatusCode(401);
        }
        
        if ($this->dateRangeIsValid() == false) {
            return $this->getResponse()->setStatusCode(400);
        }
        
        $dateRangeParameters = $this->getDateRangeParameters();
        
        $command = new getClaimReportCommand(
            'AverageByUser',
            $dateRangeParameters
        );
        $report = $this->commandBus()->handle($command);
        
        return $this->reportResponse($report);
    }
    
    
    /**
     * @return \Zend\View\Model\JsonModel|\Zend\Http\Response
     */
    public function claimsQuantityByMonthAction()
    {
        if (!$this->session->isUserLoggedIn()) {
            return $this->getResponse()->setStatusCode(401);
        }
        
        if ($this->dateRangeIsValid() == false) {
            return $this->getResponse()->setStatusCode(400);
        }
        
        $dateRangeParameters = $this->getDateRangeParameters();
        
        $command = new getClaimReportCommand(
            'QuantityByMonth',
            $dateRangeParameters
        );
        $report = $this->commandBus()->handle($command);
        
        return $this->reportResponse($report);
    }
    
    
    /**
     * @return \Zend\View\Model\JsonModel|\Zend\Http\Response
     */
    public function claimsAcquisitionAverageByUserAction()
    {
        if (!$this->session->isUserLoggedIn()) {
            return $this->getResponse()->setStatusCode(401);
        }
        
        if ($this->dateRangeIsValid() == false) {
            return $this->getResponse()->setStatusCode(400);
        }
        
        $dateRangeParameters = $this->getDateRangeParameters();
        
        $command = new getClaimReportCommand(
            'AcquisitionAverageByUser',
            $dateRangeParameters
        );
        $report = $this->commandBus()->handle($command);
        
        return $this->reportResponse($report);
    }
    
    
    /**
     * @return \Zend\View\Model\JsonModel|\Zend\Http\Response
     */
    public function claimsBestMonthAction()
    {
        if (!$this->session->isUserLoggedIn()) {
            return $this->getResponse()->setStatusCode(401);
        }
        
        if ($this->dateRangeIsValid() == false) {
            return $this->getResponse()->setStatusCode(400);
        }
        
        $dateRangeParameters = $this->getDateRangeParameters();
        
        $command = new getClaimReportCommand(
            'BestMonth',
            $dateRangeParameters
        );
        $report = $this->commandBus()->handle($command);
        
        return $this->reportResponse($report);
    }
}
