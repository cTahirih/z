<?php
namespace App\Infrastructure\Csv;

/**
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
interface FieldsMapperInterface
{
    /**
     * Transforms a CSV value to a database value. For example, a date string
     * like `14/06/2018` to `2018-06-14`.
     *
     * @param string $field Field name
     * @param mixed $value Value from CSV
     * @return mixed Transformed value
     */
    public function transformValueFromCsv(string $field, $value);
}
