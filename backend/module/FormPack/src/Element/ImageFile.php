<?php
namespace FormPack\Element;

use RuntimeException;
use Zend\Form\Element\File;

/**
 * The ImageFile element solves the optional file upload problem. Take the
 * following case:
 *
 * - A user must upload an image while creating a record.
 * - When editing, the user may upload a new image or not. The latter implies
 *   he/she wants to keep the already uploaded image.
 *
 * An ImageFile is a File element with a "filename" concept. After instancing
 * your Form and before processing a POST request, set the Filename on all
 * ImageFile elements.  
 * After your Form is valid, get the Filename with `getFilename()`. You will
 * get either the old value (if the user did not upload a new image) or the
 * new filename from the recently uploaded file.
 *
 * When instancing or adding an ImageFile to the Form you must setup these
 * options:
 *
 * - `upload_dir` -- the directory where the file will be uploaded (you might
 *   want to use a variable or constant in order to pass it too to a
 *   RenameUpload filter). Must end in a slash.
 *   Example: "public/media/uploads/"
 * 
 * - `web_path` -- the URL directory where the file can be publicly accessed.
 *   Must end in a slash.
 *   Note: This variable will be prepended with the BasePath View Helper.
 *   Example: "media/uploads/"
 *
 * - `allow_remove' (Optional) -- If set to `true`, the View Helper will render
 *   a checkbox that allows the user to "remove" the file. This is on the
 *   case of an optional ImageFile, where you don't want an empty upload be
 *   interpreted as "keep the one we already have."
 *   Note: You need to handle any cleanup by yourself (i.e. remove the file
 *   from the filesystem).
 *
 * See also the FormPack\ViewHelper\FormImageFile.php View Helper.
 * 
 * @see File
 * @package FormPack
 * @author Jaime Wong <j@jgwong.org>
 */
class ImageFile extends File
{
    /**
     * @var array
     */
    protected $attributes = array(
        'type' => 'imagefile',
    );
    
    /**
     * @var string
     */
    protected $filename;
    
    
    /**
     * @return string|null
     */
    public function getFilename()
    {
        $value = $this->getValue();
        
        if (!is_null($value) && ($value['error'] == 0)) {
            $this->setFilename($value['name']);
            return $this->filename;
        }
        
        return $this->filename;
    }
    
    
    /**
     * @param string|null $filename
     * @return ImageFile
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
        return $this;
    }
    
    
    /**
     * @throws RuntimeException
     * @return string
     */
    public function getUploadDir()
    {
        $uploadDir = $this->getOption('upload_dir');
        
        if (is_null($uploadDir)) {
            throw new RuntimeException('Undefined upload directory option for ImageFile element "' . $this->getName() . '"');
        }
        
        return $uploadDir;
    }
    
    
    /**
     * @throws RuntimeException
     * @return string
     */
    public function getWebPath()
    {
        $webPath = $this->getOption('web_path');
        
        if (is_null($webPath)) {
            throw new RuntimeException('Undefined web path option for ImageFile element "' . $this->getName() . '"');
        }
        
        return $webPath;
    }
    
    
    /**
     * Returns the web-accessible path to the image file.
     *
     * @return string
     */
    public function getWebFilename()
    {
        return $this->getWebPath() . $this->getFilename();
    }
}
