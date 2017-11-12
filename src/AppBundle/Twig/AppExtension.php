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

    public function serviceFilter($id)
    {
         /**@var \AppBundle\Repository\ServiceRepository $serviceRepository **/
        $serviceRepository = $this->doctrine->getRepository(Service::class);

        $service =  $serviceRepository->find($id);

        return $service;
    }

}