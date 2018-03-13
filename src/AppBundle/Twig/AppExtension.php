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

    public function serviceFilter($dateStart, $dateEnd, $car)
    {
        /** @var \AppBundle\Repository\PriceRepository $priceRepository */
        $priceRepository   = $this->getDoctrine()->getRepository(Price::class);

        $nbJours = $dateEnd - $dateStart;

        if($nbJours === 1) {
            $price = $priceRepository->getPriceCarByService($car, 1);
        }
        elseif ($nbJours === 4) {
            $price = $priceRepository->getPriceCarByService($car, 2);
        }
        else {
            $price = $priceRepository->getPriceCarByService($car, 1) * $nbJours + 3600 * 24;
        }

        return $price;
    }

}