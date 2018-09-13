<?php
namespace App\Application\Command;

use App\Infrastructure\Csv\CsvReaderInterface;
use App\Infrastructure\Csv\FieldsMapperInterface;
use App\Infrastructure\Repository\RepositoryWithInsertBatchInterface;
use DDD\Command\Command;
use DDD\Command\CommandHandlerInterface;

/**
 * Imports records from a CSV file. Returns the number of rows inserted.
 *
 * @see CommandHandler
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
abstract class AbstractImportCsvCommandHandler implements CommandHandlerInterface
{
    /**
     * @var CsvReaderInterface
     */
    protected $csvReader;
    
    /**
     * @var RepositoryWithInsertBatchInterface
     */
    protected $repository;
    
    /**
     * @var FieldsMapperInterface
     */
    protected $csvFieldsMapper;
    
    
    /**
     * @param CsvReaderInterface $csvReader
     * @param RepositoryWithInsertBatchInterface $repository
     * @param FieldsMapperInterface $csvFieldsMapper
     * @return void
     */
    public function __construct(
        CsvReaderInterface $csvReader,
        RepositoryWithInsertBatchInterface $repository,
        FieldsMapperInterface $csvFieldsMapper
    ) {
        $this->csvReader       = $csvReader;
        $this->repository      = $repository;
        $this->csvFieldsMapper = $csvFieldsMapper;
    }
    
    
    /**
     * @param Command $command
     * @return integer
     */
    public function handle(Command $command)
    {
        $csvFileName = $command->getCsvFileName();
        
        $this->csvReader->open($csvFileName);
        $rows = $this->csvReader->getRows();
        
        /**
         * We're going to insert rows in bulk, for performance reasons.
         * We accumulate a batch of rows, then insert them into the repository.
         */
        $batchSize  = 500;
        $totalCount = 0;
        $count      = 0;
        $data       = [];
        
        foreach ($rows as $row) {
            $row = $this->csvFieldsMapper->mapCsvToTableFields($row);
            
            $data[] = $row;
            $count++;
            $totalCount++;
            
            if ($count == $batchSize) {
                $this->repository->insertBatch($data);
                $count = 0;
                $data  = [];
            }
        }
        
        // Insert any reminder rows
        $this->repository->insertBatch($data);
        
        return $totalCount;
    }
}
