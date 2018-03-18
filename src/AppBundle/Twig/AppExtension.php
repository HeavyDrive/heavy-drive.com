<?php
/**
 * Created by PhpStorm.
 * User: ashley
 * Date: 15/09/17
 * Time: 17:15
 */

namespace AppBundle\Twig;


use Proxies\__CG__\AppBundle\Entity\Service;
use Symfony\Bridge\Doctrine\RegistryInterface;

class AppExtension extends \Twig_Extension
{
    protected $doctrine;

    public function __construct(RegistryInterface $doctrine){

        $this->doctrine = $doctrine;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('service', array($this, 'serviceFilter')),
        );
    }

    public function serviceFilter($price)
    {
        dump($price); die;
        $nbJour = 4;

        for ($i=0; $i<$nbJour; $i++) {
            $price0 = 100 + $price;
        }

        return $price;
    }

}