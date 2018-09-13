<?php
namespace App\Application\Dto\Report;

use Webmozart\Assert\Assert;

/**
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class MachinesQuantityByMonth
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
        
        foreach ($data as $row) {
            Assert::keyExists($row, 'month');
            Assert::keyExists($row, 'year');
            
            Assert::keyExists($row, 'total');
            Assert::keyExists($row['total'], 'all');
            Assert::keyExists($row['total'], 'gold');
            Assert::keyExists($row['total'], 'platinum');
            
            Assert::keyExists($row, 'average');
            Assert::keyExists($row['average'], 'gold');
            Assert::keyExists($row['average'], 'platinum');
        }
        
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
        $data = [];
        
        foreach ($this->data as $row) {
            $data[] = [
                'Mes'                => $row['month'],
                'Año'                => $row['year'],
                'Total - Todos'      => $row['total']['all'],
                'Total - Oro'        => $row['total']['gold'],
                'Total - Platino'    => $row['total']['platinum'],
                'Promedio - Oro'     => $row['average']['gold'],
                'Promedio - Platino' => $row['average']['platinum'],
            ];
        }
        
        return $data;
    }
}
