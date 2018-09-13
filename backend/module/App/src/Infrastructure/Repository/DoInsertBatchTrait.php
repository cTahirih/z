<?php
namespace App\Infrastructure\Repository;

use Zend\Db\Adapter\ParameterContainer;
use Zend\Db\TableGateway\TableGateway;

/**
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
trait DoInsertBatchTrait
{
    /**
     * Insert many rows as one query.
     *
     * Code adapted from: https://gist.github.com/newage/e7336d05747330b0524f
     *
     * @param array $data
     * @return bool
     */
    public function doInsertBatch(TableGateway $tableGateway, array $data)
    {
        $sqlStringTemplate = 'INSERT INTO %s (%s) VALUES %s';
        $adapter = $tableGateway->getAdapter(); /* Get adapter from tableGateway */
        $driver = $adapter->getDriver();
        $platform = $adapter->getPlatform();

        $tableName = $platform->quoteIdentifier($tableGateway->getTable());
        $parameterContainer = new ParameterContainer();
        $statementContainer = $adapter->createStatement();
        $statementContainer->setParameterContainer($parameterContainer);

        /* Preparation insert data */
        $insertQuotedValue = [];
        $insertQuotedColumns = [];
        $i = 0;
        foreach ($data as $insertData) {
            $fieldName = 'field' . ++$i . '_';
            $oneValueData = [];
            $insertQuotedColumns = [];
            foreach ($insertData as $column => $value) {
                $oneValueData[] = $driver->formatParameterName($fieldName . $column);
                $insertQuotedColumns[] = $platform->quoteIdentifier($column);
                $parameterContainer->offsetSet($fieldName . $column, $value);
            }
            $insertQuotedValue[] = '(' . implode(',', $oneValueData) . ')';
        }

        /* Preparation sql query */
        $query = sprintf(
            $sqlStringTemplate,
            $tableName,
            implode(',', $insertQuotedColumns),
            implode(',', array_values($insertQuotedValue))
        );

        $statementContainer->setSql($query);
        return $statementContainer->execute();
    }
}
