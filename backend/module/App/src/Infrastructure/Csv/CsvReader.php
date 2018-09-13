<?php
namespace App\Infrastructure\Csv;

use League\Csv\Reader;
use Traversable;

/**
 * @see CsvReaderInterface
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class CsvReader implements CsvReaderInterface
{
    /**
     * @var Traversable
     */
    protected $csv;
    
    
    /**
     * Opens a CSV file for reading.
     *
     * @param string $csv
     * @return void
     */
    public function open(string $csv)
    {
        $this->csv = Reader::createFromPath($csv);
        $this->csv->setHeaderOffset(0);
    }
    
    
    /**
     * @return Traversable
     */
    public function getRows()
    {
        return $this->csv;
    }
}
