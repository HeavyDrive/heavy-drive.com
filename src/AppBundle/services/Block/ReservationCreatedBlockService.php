<?php
/**
 * Created by PhpStorm.
 * User: ashley
 * Date: 27/03/18
 * Time: 16:42
 */

namespace AppBundle\services\Block;


use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class ReservationCreatedBlockService extends AbstractBlockService
{
    private $entityManager;

    /**
     * ReservationCreatedBlockService constructor.
     *
     * @param null $name
     * @param EngineInterface|null $templating
     */
    public function __construct($name = null, EngineInterface $templating = null)
    {
        /*$reservationID = "";
        EngineInterface $templating;
        parent::__construct($name, $templating);*/
    }

}