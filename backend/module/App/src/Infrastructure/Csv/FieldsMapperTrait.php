<?php
namespace App\Infrastructure\Csv;

/**
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
trait FieldsMapperTrait
{
    /**
     * @param array $data
     * @return array
     */
    public function mapCsvToTableFields(array $data)
    {
        $result = [];
        
        foreach ($data as $csvField => $value) {
            if (array_key_exists($csvField, $this->csvToTableMap)) {
                $tableField = $this->csvToTableMap[$csvField];
                $result[$tableField] = $this->transformValueFromCsv($tableField, $value);
            }
        }
        
        return $result;
    }
}
