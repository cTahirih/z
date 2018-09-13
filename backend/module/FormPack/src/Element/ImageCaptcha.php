<?php
namespace FormPack\Element;

use Zend\Captcha\Image;
use Zend\Form\Element\Captcha;

/**
 * Provides an Image Captcha with sensible defaults.
 *
 * @see Captcha
 * @package FormPack
 * @author Jaime G. Wong <j@jgwong.org>
 */
class ImageCaptcha extends Captcha
{
    /**
     * {@inheritDoc}
     */
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        
        $image = new Image([
            'expiration'    => 3600,
            'wordlen'       => 5,
            'font'          => __DIR__ . '/../Font/arial.ttf',
            'fontSize'      => 22,
            'width'         => 126,
            'height'        => 60,
            'imgDir'        => 'public/captcha',
            'imgUrl'        => '/captcha',
            'dotNoiseLevel' => 50,
            'messages'      => array(
                'badCaptcha' => 'El CAPTCHA es incorrecto'
            ),
        ]);
        $this->setCaptcha($image);
    }
}
