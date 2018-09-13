<?php
namespace FormPack\Filter;

use Zend\Filter\AbstractFilter;

/**
 * File Upload. Fixes a "bug" in FileRenameUpload filter where a randomized
 * file name is not updated in the `name` key of the array.
 *
 * For this to work, this filter should always run *after* FileRenameUpload.
 * The best way to guarantee this is by explicitely defining priorities
 * (using the `priority` key in the factory configuration array).
 *
 * @see AbstractFilter
 * @package FormPack
 * @author Jaime G. Wong <j@jgwong.org>
 */
class FileRenameUploadFix extends AbstractFilter
{
    /**
     * @param array
     * @return array
     */
    public function filter($value)
    {
        if (!empty($value['name'])) {
            $value['name'] = basename($value['tmp_name']);
        }
        return $value;
    }
}
