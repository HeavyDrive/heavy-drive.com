<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Acl\Exception\Exception;
use Symfony\Component\Validator\Constraints\File;

class APIController extends Controller
{
    /**
     * @Route("/storage", name="storage")
     */
    public function readAction()
    {
        try
        {
            $file = new File('2.jpg');
            $cloudstorage = $this->container->get('app.googlecloud');
            $cloudstorage->storageAccess($file);
        }

        catch (Exception $e)
        {
            echo 'Exception : ',  $e->getMessage(), "\n";
        }
    }
}