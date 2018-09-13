<?php
/**
 * This file is part of AdminAuth2 Zend Framework 2 module.
 */

namespace AdminAuth2\Provider;

/**
 * @package AdminAuth2
 * @version v1.0.0
 * @author Jaime Wong <jaime.wong@nodosdigital.pe>
 */
trait ListProviderTrait
{
    /**
     * @var int
     */
    protected $pageNumber = 1;
    
    
    /**
     * @return integer
     * @since v1.0.0
     */
    public function getCurrentPage()
    {
        return $this->pageNumber;
    }
    
    
    /**
     * Set current page for pagination.
     *
     * @param int $pageNumber
     * @return self
     * @since v1.0.0
     */
    public function setCurrentPage($pageNumber)
    {
        if ($pageNumber < 1) {
            $pageNumber = 1;
        }
        $this->pageNumber = $pageNumber;
        
        return $this;
    }
}
