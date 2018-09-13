<?php
namespace App\Infrastructure\Repository;

interface RepositoryWithInsertBatchInterface
{
    /**
     * @param array $data
     * @return void
     */
    public function insertBatch(array $data);
}
