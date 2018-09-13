<?php
namespace App\Infrastructure\Csv;

use DateTime;
use RuntimeException;

/**
 * Maps CSV field names to database table field names.
 *
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class MachineFieldsMapper implements FieldsMapperInterface
{
    use FieldsMapperTrait;
    
    /**
     * @var array
     */
    protected $csvToTableMap;
    
    
    /**
     * @return void
     */
    public function __construct()
    {
        $this->csvToTableMap = [
            'entity_id' => 'entity_id',
            'name'      => 'name',
            'is_active' => 'is_active',
            'type'      => 'type',
        ];
    }
    
    
    /**
     * Transforms a CSV value to a database value. For example, a date string
     * like `14/06/2018` to `2018-06-14`.
     *
     * @param string $field Field name
     * @param mixed $value Value from CSV
     * @return mixed Transformed value
     */
    public function transformValueFromCsv(string $field, $value)
    {
        return $value;
    }
}
