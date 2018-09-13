<?php
namespace App\Infrastructure\Csv;

use Iterator;

interface CsvReaderInterface
{
    /**
     * Opens a CSV file for reading.
     *
     * @param string $csv Full path name to CSV file in filesystem.
     * @return void
     */
    public function open(string $csv);
    
    
    /**
     * @return Iterator Returns an Interator to read every row of the CSV
     * file..
     */
    public function getRows();
}
