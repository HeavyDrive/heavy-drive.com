<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Route\RouteCollection;

class ReservationCreatedAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'reservation_created';
    protected $baseRouteName = 'reservation_created';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['list']);
    }
}