<?php
namespace FormPack\Util;

use FormPack\Element\ImageFile;
use RuntimeException;

trait RemoveImageFileTrait
{
    /**
     * If marked for removal, clear the Filename on the declared array of
     * ImageFiles.
     *
     * @throws RuntimeException
     * @return void
     */
    public function removeImageFiles()
    {
        if (is_null($this->removeImageFileElements)) {
            $this->removeImageFileElements = array();
        }
        
        foreach ($this->removeImageFileElements as $elementName) {
            $imageFile = $this->get($elementName);
            
            if (!$imageFile instanceof ImageFile) {
               throw new RuntimeException(sprintf(
                   'Element "%s" is not a FormPack\Element\ImageFile element.',
                   $imageFile->getName()
               ));
            }
            
            if ($imageFile->getOption('allow_remove')) {
                $name = $imageFile->getName() . '-ImageFileRemove';
                
                if (isset($_POST[$name])) {
                    $imageFile->setFilename(null);
                }
            }
        }
    }
    
    
    /**
     * {@inheritDoc}
     */
    public function isValid()
    {
        $this->removeImageFiles();
        return parent::isValid();
    }
}
