<?php
namespace App\Application\Dto\Report;

use Webmozart\Assert\Assert;

/**
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class MachinesBestMonth
{
    /**
     * @var array
     */
    protected $data;
    
    
    /**
     * @param array $data
     * @return void
     */
    public function __construct(array $data)
    {
        Assert::isArray($data);
        Assert::keyExists($data, 'month');
        Assert::keyExists($data, 'year');
        
        $this->data = $data;
    }
    
    
    /**
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }
    
    
    /**
     * @return array
     */
    public function toCsvArray()
    {
        return [
            [
                'Mes' => $this->data['month'],
                'Año' => $this->data['year'],
            ],
        ];
    }
}
