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
class UserMachineFieldsMapper implements FieldsMapperInterface
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
            'entity_id'     => 'entity_id',
            'machine_id'    => 'machine_id',
            'customer_id'   => 'user_id',
            'code'          => 'code',
            'how'           => 'how',
            'where'         => 'where',
            'purchase_date' => 'purchase_date',
            'creation_time' => 'creation_date',
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
