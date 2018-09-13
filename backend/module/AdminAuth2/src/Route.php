<?php
namespace AdminAuth2;

use InvalidArgumentException;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

/**
 * @package AdminAuth2
 * @author Jaime G. Wong <j@jgwong.org>
 */
class Route
{
    /**
     * Returns an array for a common AdminAuth2 CRUD route specification.
     *
     * Should receive an array with `route` and `controller` keys. I chose to do
     * it as an array rather than parameters in order to have verbosity on the
     * route specification.
     *
     * @param array $spec
     * @return array
     */
    static public function route($spec)
    {
        if (!isset($spec['route'])) {
            throw new InvalidArgumentException('Undefined route in AdminAuth2 route specification');
        }
        
        if (!isset($spec['controller'])) {
            throw new InvalidArgumentException('Undefined controller in AdminAuth2 route specification');
        }
        
        return [
            'type' => Literal::class,
            'options' => [
                'route' => $spec['route'],
                'defaults' => [
                    'controller' => $spec['controller'],
                    'action' => 'list',
                ],
            ],
            'may_terminate' => true,
            
            'child_routes' => [
                'view' => [
                    'type' => Segment::class,
                    'options' => [
                        'route' => '/view/:id',
                        'constraints' => [
                            'id' => '[0-9]+',
                        ],
                        'defaults' => [
                            'action' => 'view',
                        ],
                    ],
                ],
                
                'add' => [
                    'type' => Literal::class,
                    'options' => [
                        'route' => '/add',
                        'defaults' => [
                            'action' => 'add',
                            'id' => '0',
                        ],
                    ],
                ],
                
                'edit' => [
                    'type' => Segment::class,
                    'options' => [
                        'route' => '/edit/:id',
                        'constraints' => [
                            'id' => '[0-9]+',
                        ],
                        'defaults' => [
                            'action' => 'edit',
                        ],
                    ],
                ],
                
                'delete' => [
                    'type' => Segment::class,
                    'options' => [
                        'route' => '/delete/:id',
                        'constraints' => [
                            'id' => '[0-9]+',
                        ],
                        'defaults' => [
                            'action' => 'delete',
                        ],
                    ],
                ],
            ],
        ];
    }
}
