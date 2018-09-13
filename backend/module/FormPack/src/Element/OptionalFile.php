<?php
namespace FormPack\Element;

use Zend\Form\Element\File;
use Zend\Stdlib\ArrayUtils;

/**
 * The OptionalFile element solves the optional file upload problem. Take the
 * following case:
 *
 * - A user must upload an image while creating a record.
 * - When editing, the user may upload a new image or not, because he/she wants
 *   to keep the already uploaded image.
 * - Also, the user may want to remove the current file.
 *
 * An OptionalFile is a File element with a "current file name" concept. After
 * instancing your Form and before processing a POST request, set the file
 * name on all your OptionalFile elements.  
 * After your Form is valid, get the file name with `getFileName()`. You will
 * get either the old value (if the user did not upload a new image), the
 * new file name from the recently uploaded file (if the user did upload a new
 * file) or null in case the file was marked to be removed.
 *
 * It's a good idea to overload the Form's getData() and call getFileName()
 * there in order to return the file name in the resulting array. This way
 * the process is very transparent to the developer.
 *
 * This element works with the FormPack\ViewHelper\FormOptionalFile View
 * Helper.
 *
 * Options:
 *
 * - `show_view_link` (Optional, default false) -- If true, the View Helper
 *   will render a link to view the current file.
 *
 * - `allow_remove' (Optional, default false) -- If set to `true`, the View
 *   Helper will render a checkbox that allows the user to "remove" the file.
 *   This is needed because we can't otherwise tell if an empty upload should
 *   be interpreted as "keep the one we already have" or "I don't want a file
 *   anymore."
 *   Note: You still need to handle any cleanup by yourself (i.e. unlink the
 *   file on the file system).
 *
 * Attributes:
 *
 * - `view_link` -- Array with attributes for the view link.
 * 
 * @see File
 * @package FormPack
 * @author Jaime Wong <j@jgwong.org>
 */
class OptionalFile extends File
{
    /**
     * @var array
     */
    protected $attributes = array(
        'type' => 'optionalfile',
    );
    
    /**
     * @var string
     */
    protected $currentFileName = '';
    
    
    /**
     * @var string
     */
    protected $viewFileName;
    
    
    /**
     * {@inheritDoc}
     */
    public function setOptions($options)
    {
        $defaultOptions = [
            'show_view_link' => false,
            'allow_remove'   => false,
            'file_rename_upload' => [
                'target'          => 'public/',
                'use_upload_name' => true,
                'randomize'       => true,
            ],
        ];
        $options = ArrayUtils::merge($defaultOptions, $options);
        
        return parent::setOptions($options);
    }
    
    
    /**
     * Returns the "current" file name, where "current" means the one stored
     * and that will be overwritten, removed or returned as is.
     *
     * @return string|null
     */
    public function getCurrentFileName()
    {
        return $this->currentFileName;
    }
    
    
    /**
     * @param string|null $filename
     * @return OptionalFile
     */
    public function setCurrentFileName($fileName)
    {
        $this->currentFileName = $fileName;
        return $this;
    }
    
    
    /**
     * Get the View file name. Unless specifically set, returns the current
     * file name by default. This is in case the web-accesible file name
     * differs from the current file name (e.g. only filename vs. full path).
     *
     * @return string
     */
    public function getViewFileName()
    {
        if (is_null($this->viewFileName)) {
            return $this->currentFileName;
        }
        
        return $this->viewFileName;
    }
    
    
    /**
     * @param string $name
     * @return string
     */
    public function setViewFileName($name)
    {
        $this->viewFileName = $name;
    }
    
    
    /**
     * This is where the magic happens. $upload should be the array of the file
     * upload returned by Zend\Form\Form::getData(). Why not to grab the value
     * from the Element itself? Because The array returned by Form::getData()
     * is filtered by the InputFilter. Thus, we can only get the renamed
     * file name via Form::getData(), not from the Element's getValue().  
     * Sad, but true.
     *
     * @param array $upload A "PHP file upload"-formatted array
     * @return string|null File name or null if removed
     */
    public function getFileName($upload)
    {
        if (!is_array($upload)) {
            throw new \RuntimeException("Expected to receive an array with a File Upload structure");
        }
        
        // Has a file been uploaded?
        if ($upload['error'] == 0) {
            return $upload['tmp_name'];
        }
        
        // Has the file been removed?
        if ($this->isRemoved()) {
            return null;
        }
        
        // Neither, then return the current file name
        return $this->getCurrentFileName();
    }
    
    
    /**
     * Returns true if the file was removed. We do this by inspecting a POST
     * variable directly. Sorry for the hack.  
     * This variable comes from a checkbox rendered on the OptionalFile View
     * Helper. If `allow_remove` option is false this will always return false.
     *
     * @return bool
     */
    public function isRemoved()
    {
        if ($this->getOption('allow_remove') == false) {
            return false;
        }
        return isset($_POST[$this->getRemoveName()]);
    }
    
    
    /**
     * Returns the name to be used for the remove Checkbox or data key.
     *
     * @return string
     */
    public function getRemoveName()
    {
        return str_replace(['[', ']'], '_', 'image_file_remove_' . $this->getName());
    }
    
    
    /**
     * {@inheritDoc}
     */
    public function getInputSpecification()
    {
        $spec = [
            'filters' => [
                [
                    'name' => 'FileRenameUpload',
                    'options' => $this->getOption('file_rename_upload'),
                    'priority' => 1000,
                ],
                
                [
                    'name' => 'FormPack\Filter\FileRenameUploadFix',
                    'priority' => 800, // Should run *after* FileRenameUpload
                ],
            ],
        ];
        
        return ArrayUtils::merge($spec, parent::getInputSpecification());
    }
}
