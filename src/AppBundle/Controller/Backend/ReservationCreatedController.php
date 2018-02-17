<?php

namespace AppBundle\Controller\Backend;

use Sonata\AdminBundle\Controller\CRUDController;

class ReservationCreatedController extends CRUDController
{
    public function listAction()
    {
        return $this->renderWithExtraParams('backend/admin/reservation_created.html.twig');
    }
}