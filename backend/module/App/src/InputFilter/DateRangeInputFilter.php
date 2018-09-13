<?php
namespace App\InputFilter;

use Zend\InputFilter\InputFilter;

/**
 * @see InputFilter
 * @package App
 * @author Jaime G. Wong <j@jgwong.org>
 */
class DateRangeInputFilter extends InputFilter
{
    /**
     * @return void
     */
    public function __construct()
    {
        $months = range(1, 12);
        $years  = range(2015, date('Y'));
        
        $this->add([
            'name' => 'start_month',
            'required' => true,
            'validators' => [
                [
                    'name' => 'InArray',
                    'options' => [
                        'haystack' => $months,
                    ],
                ],
            ],
        ]);
        
        $this->add([
            'name' => 'start_year',
            'required' => true,
            'validators' => [
                [
                    'name' => 'InArray',
                    'options' => [
                        'haystack' => $years,
                    ],
                ],
            ],
        ]);
        
        $this->add([
            'name' => 'end_month',
            'required' => true,
            'validators' => [
                [
                    'name' => 'InArray',
                    'options' => [
                        'haystack' => $months,
                    ],
                ],
            ],
        ]);
        
        $this->add([
            'name' => 'end_year',
            'required' => true,
            'validators' => [
                [
                    'name' => 'InArray',
                    'options' => [
                        'haystack' => $years,
                    ],
                ],
            ],
        ]);
    }
}
