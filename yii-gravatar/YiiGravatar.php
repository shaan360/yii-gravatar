<?php
/**
 * YiiGravatar class file.
 *
 * @author Sergey Malyshev <malyshev.php@gmail.com>
 */

Yii::setPathOfAlias('yii-gravatar', dirname(__FILE__));

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
class YiiGravatar extends CComponent
{

    private $_imageRequest;
    
    public function init()
    {

    }

    public function setImage(array $params)
    {
        if (null === $this->_imageRequest)
        {
            $params['class'] = 'yii-gravatar.YiiGravatarImage';
            $this->_imageRequest = Yii::createComponent($params);
        }
        return $this->_imageRequest;
    }

    public function createImage($email)
    {
        if (null === $this->_imageRequest)
        {
            $this->_imageRequest = Yii::createComponent('yii-gravatar.YiiGravatarImage');
        }
        return $this->_imageRequest->create($email);
    }

}