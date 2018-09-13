<?php
/**
 * What we do here is a namespacing trick to monkey-patch `is_uploaded_file`
 * and `move_uploaded_file` internal PHP functions. These two functions
 * validate a file has really been uploaded and thus complicates Unit
 * Testing.
 *
 * Here we are replacing them with alternatives that still work.
 *
 * Just "use" this trait on your class and you're done. Kinda hackish,
 * but works. :)
 *
 * @author Jaime G. Wong <j@jgwong.org>
 */

namespace BaseTest
{
    trait FakeFileUpload
    {
    }
}


namespace Zend\Validator\File
{
    function is_uploaded_file($filename)
    {
        return file_exists($filename);
    }
}


namespace Zend\Filter\File
{
    function move_uploaded_file($filename, $destination)
    {
        return copy($filename, $destination);
    }
}
