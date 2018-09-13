<?php
/**
 * This file is part of RenderCsv Zend Framework 2 module.
 */

namespace RenderCsv;

use League\Csv\AbstractCsv;
use Zend\Http\Response;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

/**
 * Renders a League\Csv\AbstractCsv object.
 *
 * @see AbstractPlugin
 * @package RenderCsv
 * @version v1.0.0
 * @author Jaime Wong <jaime.wong@nodosdigital.pe>
 */
class RenderCsvPlugin extends AbstractPlugin
{
    /**
     * Returns a Response with the contents of League\Csv\AbstractCsv for
     * download.
     *
     * @param AbstractCsv $csv
     * @param string $filename
     * @return Response
     * @since v1.0.0
     */
    public function __invoke(AbstractCsv $csv, $filename = 'export.csv')
    {
        $response = new Response();
        $response->getHeaders()->addHeaderLine('Content-Encoding', 'UTF-8');
        $response->getHeaders()->addHeaderLine('Content-Type', 'text/csv; charset=UTF-8');
        $response->getHeaders()->addHeaderLine('Content-Disposition', sprintf('attachment; filename="%s"', $filename));
        $response->setContent((string) $csv);
        return $response;
    }
}
