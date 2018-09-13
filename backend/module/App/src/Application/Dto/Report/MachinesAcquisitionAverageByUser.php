<?php
namespace App\Application\Dto\Report;

use Webmozart\Assert\Assert;

/**
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class MachinesAcquisitionAverageByUser
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
        Assert::keyExists($data, 'all');
        Assert::keyExists($data, 'gold');
        Assert::keyExists($data, 'platinum');
        
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
                'Todos'   => $this->data['all'],
                'Oro'     => $this->data['gold'],
                'Platino' => $this->data['platinum'],
            ],
        ];
    }
}
