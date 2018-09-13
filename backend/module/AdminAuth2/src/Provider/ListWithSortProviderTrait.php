<?php
namespace AdminAuth2\Provider;

use AdminAuth2\Provider\ListHeader;
use RuntimeException;
use Webmozart\Assert\Assert;

/**
 * A trait for a List Provider that also handles sorted fields.
 * 
 * @package AdminAuth2
 * @author Jaime G. Wong <j@jgwong.org>
 *
 */
trait ListWithSortProviderTrait
{
    /**
     * @var string
     */
    protected $sortField;
    
    /**
     * @var string
     */
    protected $sortDirection;
    
    /**
     * @var array
     */
    protected $slugToHeaderMap;
    
    
    /**
     * @return string|null
     * @since v1.0.0
     */
    public function getListSortField()
    {
        return $this->sortField;
    }
    
    
    /**
     * @param string|null $field
     * @return self
     * @since v1.0.0
     */
    public function setListSortField($field)
    {
        Assert::nullOrString($field);
        
        if (!in_array($field, $this->getAllowedSortFields())) {
            $field = null;
        }
        
        $this->sortField = $field;
        return $this;
    }
    
    
    /**
     * Returns an array map of Slugs to ListHeaders. Key is the slug, value
     * is the ListHeader.
     *
     * @return array
     * @since v1.0.0
     */
    public function getSlugToListHeaderMap()
    {
        if (!is_null($this->slugToHeaderMap)) {
            return $this->slugToHeaderMap;
        }
        
        $map = [];
        
        // By default builds a list from `getListHeaders()`
        foreach ($this->getListHeaders() as $header) {
            if ($header instanceof ListHeader && $header->isSortable()) {
                $slug = $header->getSlug();
                
                if (array_key_exists($slug, $map)) {
                    throw new RuntimeException(sprintf('Duplicate slug "%s" found in ListHeaders.'));
                }
                
                $map[$header->getSlug()] = $header;
            }
        }
        
        $this->slugToHeaderMap = $map;
        return $this->slugToHeaderMap;
    }
    
    
    /**
     * Returns an array of accepted sort fields so a User can't mangle queries
     * via the URL.
     *
     * @return array
     * @since v1.0.0
     */
    public function getAllowedSortFields()
    {
        return array_keys($this->getSlugToListHeaderMap());
    }
    
    
    /**
     * @return string|null Either `asc` or `desc`.
     * @since v1.0.0
     */
    public function getListSortDirection()
    {
        return $this->sortDirection;
    }
    
    
    /**
     * @param string|null $direction Either `asc` or `desc`.
     * @return void
     * @since v1.0.0
     */
    public function setListSortDirection($direction)
    {
        Assert::nullOrOneOf($direction, ['asc', 'desc']);
        
        $this->sortDirection = $direction;
        return $this;
    }
    
    
    /**
     * Returns the `property` attribute of the current selected sorting header.
     *
     * @return string|null
     * @since v1.0.0
     */
    public function getListSortProperty()
    {
        $sortField = $this->getListSortField();
        
        if (is_null($sortField)) {
            return null;
        }
        
        $map = $this->getSlugToListHeaderMap();
        
        if (!array_key_exists($listHeader, $map)) {
            return null;
        }
        
        $listHeader = $map[$sortField];
        return $listHeader->getProperty();
    }
}
