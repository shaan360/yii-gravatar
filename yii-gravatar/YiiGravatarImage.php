<?php
/**
 * YiiGravatarImage class file.
 *
 * @author Sergey Malyshev <malyshev.php@gmail.com>
 */

/**
 * YiiGravatarImage represents an ...
 *
 * Description of YiiGravatarImage
 *
 * @author Sergey Malyshev <malyshev.php@gmail.com>
 * @version $Id$
 * @package
 * @since 1.1.7
 */
class YiiGravatarImage extends CComponent
{
    
    const PUBLIC_API_URL = 'http://www.gravatar.com/avatar/';

    const SECURE_API_URL = 'https://secure.gravatar.com/avatar/';

    const SITE_API_URL = 'http://gravatar.com/emails/';

    const MAX_IMAGE_SIZE = 512;

    private static $_emailHashed = false;

    private static $_secure = false;

    private static $_size = 80;

    private static $_defaultImage = '404';

    private static $_rating = 'g';

    private $_email;

    private $_linked = false;

    private $_defaultImages = array(
        '404', 'mm', 'identicon',
        'monsterid', 'wavatar', 'retro'
    );
    
    private $_ratings = array(
        'g', 'pg', 'r', 'x'
    );

    public function init()
    {

    }

    public function run()
    {
        echo $this->getImage();
    }

    function  __toString()
    {
        $apiUrl = self::$_secure ? self::SECURE_API_URL : self::PUBLIC_API_URL;
        $apiUrl .= $this->getEmailHashed() ? $this->email : md5($this->email);
        return $apiUrl . '?' . http_build_query($this->getApiParams());
    }

    public function linked($value = true)
    {
        $this->setLinked($value);
        return $this;
    }

    public function setLinked($value=true)
    {
        $this->_linked = CPropertyValue::ensureBoolean($value);
    }

    public function getLinked()
    {
        return $this->_linked;
    }

    public function getImage($altText=false, array $htmlOptions = array())
    {
        $image = CHtml::image($this->__toString(), $altText, $htmlOptions);
        if (true === $this->_linked)
        {
            $image = CHtml::link($image, self::SITE_API_URL);
        }
        return $image;
    }

    public function getApiParams()
    {
        return array(
            'd' => self::$_defaultImage,
            'r' => self::$_rating,
            's' => self::$_size
        );
    }

    public function rating($value)
    {
        $this->setRating($value);
        return $this;
    }

    public function setRating($value)
    {
        $value = strtolower($value);
        if (false === in_array($value, $this->_ratings))
        {
            throw new CException(Yii::t('yii','Invalid rating value "{value}". Please make sure it is among ({enum}).',
				array('{value}'=>$value, '{enum}'=>implode(', ',$this->_ratings))));
        }

        self::$_rating = $value;
    }

    public function getRating()
    {
        return self::$_rating;
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
        self::$_defaultImage = $value;
    }

    public function getDefaultImage()
    {
        return self::$_defaultImage;
    }

    public function setEmail($email)
    {
        $this->_email = strtolower(trim($email));
    }

    public function getEmail()
    {
        return $this->_email;
    }

    public function create($email)
    {
        $this->setEmail($email);
        return $this;
    }

    public function email($email)
    {
        return $this->create($email);
    }

    public function secure($value = true)
    {
        $this->setSecure($value);
        return $this;
    }

    public function setSecure($value = true)
    {
       self::$_secure = CPropertyValue::ensureBoolean($value);
    }

    public function getSecure()
    {
        return self::$_secure;
    }

    public function size($size)
    {
        $this->setSize($size);
        return $this;
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

        self::$_size = $size;
    }

    public function getSize()
    {
        return self::$_size;
    }

    public function emailHashed($value = true)
    {
        $this->setEmailHashed($value);
        return $this;
    }

    public function setEmailHashed($value = true)
    {
        self::$_emailHashed = CPropertyValue::ensureBoolean($value);
    }

    public function getEmailHashed()
    {
        return self::$_emailHashed;
    }

}