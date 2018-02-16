<?php

namespace AppBundle\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ReservationCreatedController extends Controller
{
    public function listAction()
    {
        return $this->render('backend/admin/reservation_created.html.twig', []);
    }
}