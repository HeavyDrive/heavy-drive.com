<?php
/**
 * Created by PhpStorm.
 * User: ashley
 * Date: 14/03/18
 * Time: 20:31
 */

namespace AppBundle\Controller\Frontend;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class TransactionController extends Controller
{
    /**
     * @Route("/paiement", name="paiement")
     * @Method({"POST", "GET"})
     *
     * @Security("is_granted('IS_AUTHENTICATED_ANONYMOUSLY')")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function PaymentAction(Request $request)
    {
        $session         = $request->getSession();
        $priceTotalToPay = $session->get('priceTotalToPay');
        $caution         = $session->get('cautionToPay');
        $car             = $session->get('car');
        $accompte        = $session->get('accompte');

        return $this->render('frontend/reservation/paiement.html.twig', [
            'priceTotalToPay' => $priceTotalToPay,
            'caution' => $caution,
            //'trans_id' => $trans_id,
            'accompte' => $accompte,
        ]);

    }

}