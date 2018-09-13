<?php
namespace App\Controller;

use League\Csv\Writer;
use SplTempFileObject;
use Zend\View\Model\JsonModel;

/**
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
trait ReportResponseTrait
{
    /**
     * @param mixed $report
     * @return JsonModel|
     */
    public function reportResponse($report)
    {
        $export = $this->params()->fromQuery('export', false);
        
        if ($export === false) {
            return new JsonModel($report->toArray());
        }
        
        return $this->getCsv($report);
    }
    
    
    /**
     * @param mixed $report
     * @return \Zend\Http\Response
     */
    public function getCsv($report)
    {
        $data = $report->toCsvArray();
        
        $csv = Writer::createFromFileObject(new SplTempFileObject());       
        $csv->setOutputBom(Writer::BOM_UTF8);
        
        $csv->insertOne(array_keys($data[0]));
        reset($data);
        $csv->insertAll($data);
        
        return $this->renderCsv($csv);
    }
}
