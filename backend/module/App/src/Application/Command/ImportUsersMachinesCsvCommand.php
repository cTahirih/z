<?php
namespace App\Application\Command;

use DDD\Command\Command;

/**
 * @see Command
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class ImportUsersMachinesCsvCommand implements Command
{
    /**
     * @var string
     */
    protected $csvFileName;
    
    
    /**
     * @param string $csvFileName
     * @return void
     */
    public function __construct(string $csvFileName)
    {
        $this->csvFileName = $csvFileName;
    }
    
    
    /**
     * @return string
     */
    public function getCsvFileName()
    {
        return $this->csvFileName;
    }
}
