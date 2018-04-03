<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\BookingGuest;
use AppBundle\Entity\BookingOptions;
use AppBundle\Entity\Car;
use AppBundle\Entity\Client;
use AppBundle\Entity\LicenseDriver;
use AppBundle\Entity\Price;
use AppBundle\Entity\Reservation;
use AppBundle\Entity\Service;
use AppBundle\Entity\Transaction;
use AppBundle\Form\SelectedBookingDate;
use AppBundle\Form\Type\BookingGuestType;
use AppBundle\Form\Type\BookingOptionsType;
use AppBundle\Form\Type\LicenseDriverType;
use AppBundle\Form\Type\RegistrationType;
use AppBundle\Form\Type\SystemPayType;
use AppBundle\Form\Type\UserEditType;
use AppBundle\Repository\CarRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

class ReservationController extends Controller
{
    /**
     * @Route("/Reservation", name="reservation")
     * @Method({"POST", "GET"})
     *
     * @Security("is_granted('IS_AUTHENTICATED_ANONYMOUSLY')")
     *
     * @param Request $request
     * @param Car $car
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function reservationAction(Request $request)
    {
        $booking       = new Reservation();
        $bookingGuest  = new BookingGuest();
        $user          = new Client();
        $user          = $this->getUser();
        $transaction   = new Transaction();

        $session         = $request->getSession();
        $priceTotalToPay = $session->get('priceTotalToPay');
        $caution         = $session->get('cautionToPay');
        $car             = $session->get('car');
        $accompte        = $session->get('accompte');

        $bookingOptionForm = $this->get('form.factory')->createBuilder()
            ->add('optionBooking', 'entity', array(
                    'class' => 'AppBundle:BookingOptions',
                    'expanded' => true,
                    'multiple' => true,
                    'required' => true,
                    'attr' => array('id' => 'someSwitchOptionDanger'),
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('bo')
                            ->groupBy('bo.id')
                            ->orderBy('bo.name', 'ASC');
                    },)
            )
            ->add('save', SubmitType::class, array(
                'label' => 'Valider',
                'attr'=> array('class' => 'btn btn-default centered')
            ))
            ->add('add_booking', SubmitType::class, array(
                'label' => 'Confirmer réservation',
                'attr'=> array('class' => 'btn btn-default centered')
            ))->getForm();

        $form1             = $this->createForm(new BookingGuestType(), $bookingGuest);
        $formTransaction   = $this->createForm(new SystemPayType(), $transaction);

        $reservationManager  = $this->container->get('heavy.manager.reservation');
        $bookingGuestManager = $this->container->get('heavy.manager.booking_guest');

        /** @var \AppBundle\Repository\CarRepository $carRepository */
        $carRepository = $this->getDoctrine()->getRepository(Car::class);
        $car = $carRepository->findById($car);

        /** @var \AppBundle\Repository\PriceRepository $priceRepository */
        $priceRepository = $this->getDoctrine()->getRepository(Price::class);

        $priceUniq = $this->unitPrice($car);

        $trans_id = $this->getNewTransactionId();


        $optionChoose = new ArrayCollection();

        $form1->handleRequest($request);
        $formTransaction->handleRequest($request);
        $bookingOptionForm->handleRequest($request);

        if ($request->getMethod() == 'POST')
        {
            if ($form1->get('save')->isClicked()) {
                $bookingGuestManager->save($bookingGuest);
            }

            if ($bookingOptionForm->get('save')->isClicked()) {
                $optionChoose = $bookingOptionForm->get('optionBooking')->getData();
            }

            if ($bookingOptionForm->get('add_booking')->isClicked()) {

                $canBooking = $reservationManager->canBooking($user, $booking);

                if ($canBooking) {

                    $format = 'Y-m-d H:i:s';

                    $dateStart = $session->get('dateStart');
                    $dateStart = DateTime::createFromFormat($format, $dateStart);

                    $dateEnd = $session->get('dateEnd');
                    $dateEnd = DateTime::createFromFormat($format, $dateEnd);

                    $booking->setDateStart($dateStart);
                    $booking->setDateEnd($dateEnd);
                    $booking->setCar($car);
                    $booking->setStatus(Reservation::STATUS_CREATED);
                    $booking->setBill($trans_id);

                    if ($user != null)
                    {
                        $booking->setClient($user);
                    }

                    $em = $this->getDoctrine()->getEntityManager();
                    $em->persist($booking);
                    $em->flush();
                }

                $session->clear();
            }
        }

        return $this->render('frontend/user/reservation.html.twig', [
            'form1' => $form1->createView(),
            'bookingOptionForm' => $bookingOptionForm->createView(),
            'car' => $car,
            'priceRepository' => $priceRepository,
            'optionChoose' => $optionChoose,
            'priceTotalToPay' => $priceTotalToPay,
            'caution' => $caution,
            'uniqPrice' => $priceUniq,
            'trans_id' => $trans_id,
            'accompte' => $accompte,
            'formTransaction' => $formTransaction->createView()
        ]);
    }

    public function unitPrice($car)
    {
        /** @var \AppBundle\Repository\PriceRepository $priceRepository */
        $priceRepository   = $this->getDoctrine()->getRepository(Price::class);

        $uniqPrice = $priceRepository->getPriceCar($car);

        return (int)$uniqPrice[0]["totalPrice"];
    }

    public function getNewTransactionId()
    {
        /** @var \AppBundle\Repository\ReservationRepository $reservationRepository */
        $reservationRepository = $this->getDoctrine()->getRepository(Reservation::class);

        $reservation_bill = $reservationRepository->getLastBillId();

        $last_id = $reservation_bill[0]["bill"];
        $next_id = $last_id + 1;

        return $next_id;
    }

    public function getLastTransactionId()
    {
        /** @var \AppBundle\Repository\ReservationRepository $reservationRepository */
        $reservationRepository = $this->getDoctrine()->getRepository(Reservation::class);

        $reservation_bill = $reservationRepository->getLastBillId();

        return $reservation_bill[0]["bill"];
    }
}