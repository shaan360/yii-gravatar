<?php
/**
 * YiiGravatar class file.
 *
 * @author Sergey Malyshev <malyshev.php@gmail.com>
 */


/**
 * YiiGravatar represents an ...
 *
 * Description of YiiGravatar
 *
 * @author Sergey Malyshev <malyshev.php@gmail.com>
 * @version $Id$
 * @package
 * @since 1.1.7
 */
class YiiGravatar extends CWidget
{

    const PUBLIC_API_URL = 'http://www.gravatar.com/avatar/';

    const SECURE_API_URL = 'https://secure.gravatar.com/avatar/';

    const MAX_IMAGE_SIZE = 512;

    private $_emailHashed = false;

    private $_secure = false;

    private $_size = 80;

    private $_defaultImage = '404';

    private $_rating = 'g';

    private $_email;

    private $_defaultImages = array(
        '404', 'mm', 'identicon',
        'monsterid', 'wavatar', 'retro'
    );

    private $_ratings = array(
        'g', 'pg', 'r', 'x'
    );

    public $htmlOptions = array();

    public $alt = '';

    public function init()
    {

    }

    public function run()
    {
        $src = $this->_secure ? self::SECURE_API_URL : self::PUBLIC_API_URL;
        $src .= $this->getEmailHashed() ? $this->email : md5($this->email);
        $src .= '?' . http_build_query($this->getApiParams());

        echo CHtml::image($src, $this->alt, $this->htmlOptions);
    }
    
    public function getApiParams()
    {
        return array(
            'd' => $this->_defaultImage,
            'r' => $this->_rating,
            's' => $this->_size
        );
    }

    public function setRating($value)
    {
        $value = strtolower($value);
        if (false === in_array($value, $this->_ratings))
        {
            throw new CException(Yii::t('yii','Invalid rating value "{value}". Please make sure it is among ({enum}).',
				array('{value}'=>$value, '{enum}'=>implode(', ',$this->_ratings))));
        }

        $this->_rating = $value;
    }

    public function getRating()
    {
        return $this->_rating;
    }

    public function defaultImage($value)
    {
        $this->setDefaultImage($value);
        return $this;
    }

    public function setDefaultImage($value)
    {
        if (false === (strpos($value, '.')) && false === in_array($value, $this->_defaultImages))
        {
            throw new CException(Yii::t('yii','Invalid default image value "{value}". Please make sure it is among ({enum}).',
				array('{value}'=>$value, '{enum}'=>implode(', ',$this->_defaultImages))));
        }
        $this->_defaultImage = $value;
    }

    public function getDefaultImage()
    {
        return $this->_defaultImage;
    }

    public function setEmail($email)
    {
        $this->_email = strtolower(trim($email));
    }

    public function getEmail()
    {
        return $this->_email;
    }

    public function setSecure($value = true)
    {
       $this->_secure = CPropertyValue::ensureBoolean($value);
    }

    public function getSecure()
    {
        return $this->_secure;
    }

    public function setSize($size)
    {
        $size = CPropertyValue::ensureInteger($size);

        if ($size > self::MAX_IMAGE_SIZE)
        {
            $size = self::MAX_IMAGE_SIZE;
        }
        else if($size <= 0)
        {
            $size = 1;
        }

        $this->_size = $size;
    }

    public function getSize()
    {
        return $this->_size;
    }

    public function setEmailHashed($value = true)
    {
        $this->_emailHashed = CPropertyValue::ensureBoolean($value);
    }

    public function getEmailHashed()
    {
        return $this->_emailHashed;
    }

}