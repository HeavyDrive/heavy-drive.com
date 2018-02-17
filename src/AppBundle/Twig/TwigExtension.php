<?php
/**
 * Created by PhpStorm.
 * User: ashley
 * Date: 15/02/18
 * Time: 23:53
 */

namespace AppBundle\Twig;

use Twig_Extension;
use Twig_SimpleFunction;

/**
 * Class TwigExtension
 * @package AppBundle\Twig
 */
class TwigExtension extends twig_extension
{
    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('SystemPayType', array($this, 'SystemPayType')),
        );
    }
    /**
     * @param $fields
     * @return string
     */
    public function systempayForm($fields)
    {
        $inputs = '';
        foreach ($fields as $field => $value)
            $inputs .= sprintf('<input type="hidden" name="%s" value="%s">', $field, $value);
        return $inputs;
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'systempay_twig_extension';
    }
}