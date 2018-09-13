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
class UserFieldsMapper implements FieldsMapperInterface
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
            'CustomerId'       => 'customer_id',
            'Prefix'           => 'prefix',
            'FirstName'        => 'first_name',
            'MiddleName'       => 'middle_name',
            'LastName'         => 'last_name',
            'Email'            => 'email',
            'Registered_Date'  => 'registered_date',
            'ISActive'         => 'is_active',
            'NewsLetterStatus' => 'newsletter_status',
            'PointsBalance'    => 'points_balance',
            'points_delta'     => 'points_delta',
            'Mobile'           => 'mobile',
            'Telephone'        => 'telephone',
            'Address'          => 'address',
            'ZipCode'          => 'zip_code',
            'City'             => 'city',
            'DOB'              => 'dob',
            'Region'           => 'region',
            'Country'          => 'country',
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
        if (in_array($field, ['points_balance', 'points_delta'])) {
            if ($value == '') {
                return 0;
            }
        }
        
        if (in_array($field, ['registered_date', 'dob'])) {
            if (empty($value)) {
                return null;
            }
            
            $date = DateTime::createFromFormat('d/m/Y H:i', $value);
            
            if ($date === false) {
                throw new RuntimeException(sprintf('Date could not be parsed. Expected a format of \'dd/mm/yyyy hh:mm\'. Value received was: %s', $value));
            }
            
            return $date->format('Y-m-d H:i:00');
        }
        
        return $value;
    }
}
