<?php
/**
 * Created by PhpStorm.
 * User: hd
 * Date: 24/02/18
 * Time: 10:59
 */
namespace AppBundle\Twig;

class ShaExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('signature', array($this, 'encodeToSha1')),
        );
    }
    public function encodeToSha1($null, $amount, $date, $transId)
    {
        $str = "INTERACTIVE+".$amount."00+0+TEST+978+PAYMENT+SINGLE+61078196+".$date."+".$transId."+V2+6856049758297340";

        $signature = sha1($str);

        return $signature;
    }
    public function getName()
    {
        return 'sha_extension';
    }
}