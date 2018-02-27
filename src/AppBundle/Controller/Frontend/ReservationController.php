<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\BookingGuest;
use AppBundle\Entity\Car;
use AppBundle\Entity\Client;
use AppBundle\Entity\LicenseDriver;
use AppBundle\Entity\Price;
use AppBundle\Entity\Reservation;
use AppBundle\Entity\Transaction;
use AppBundle\Form\SelectedBookingDate;
use AppBundle\Form\Type\BookingGuestType;
use AppBundle\Form\Type\LicenseDriverType;
use AppBundle\Form\Type\SystemPayType;
use AppBundle\Form\Type\UserEditType;
use AppBundle\Repository\CarRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Twig\TokenParser\TransChoiceTokenParser;
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
     * @Route("/Reservation/service/{id}", name="reservation")
     * @Method({"GET", "POST"})
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
    public function reservationAction(Request $request, Car $car)
    {
        $booking       = new Reservation();
        $bookingGuest  = new BookingGuest();

        $form = $this->get('form.factory')->createBuilder()
            ->add('optionBooking', 'entity', array(
                    'class' => 'AppBundle:BookingOptions',
                    'expanded' => true,
                    'multiple' => true,
                    'attr' => array('id' => 'someSwitchOptionDanger'),
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('bo')
                            ->groupBy('bo.id')
                            ->orderBy('bo.name', 'ASC');
                    },)
            )
            ->add('save', SubmitType::class, array(
                'label' => 'Enregistré',
                'attr'=> array('class' => 'btn btn-default centered')
            ))->getForm();

        $formDate = $this->createForm(new SelectedBookingDate(), $booking);
        $form1 = $this->createForm(new BookingGuestType(), $bookingGuest);

        $user = $this->getUser();

        $reservationManager  = $this->container->get('heavy.manager.reservation');
        $bookingGuestManager  = $this->container->get('heavy.manager.booking_guest');

        /** @var \AppBundle\Repository\ReservationRepository $reservationRepository */
        $reservationRepository = $this->getDoctrine()->getRepository(Reservation::class);

        /** @var \AppBundle\Repository\CarRepository $carRepository */
        $carRepository = $this->getDoctrine()->getRepository(Car::class);

        /** @var \AppBundle\Repository\PriceRepository $priceRepository */
        $priceRepository = $this->getDoctrine()->getRepository(Price::class);

        $trans_id = $this->getNewTransactionId();

        $optionChoose = new ArrayCollection();

        if ('POST' == $request->getMethod()) {
            $form->handleRequest($request);
            $form1->handleRequest($request);
            $formDate->handleRequest($request);

            if ($form->get('save')->isClicked()) {
                $optionChoose = $form->get('optionBooking')->getData();
            }

            if ($form1->get('save')->isClicked()) {
                $bookingGuestManager->save($bookingGuest);
            }
            if ($formDate->get('save')->isClicked()) {
                $licenseDriver = $formDate->get('licenceDriver')->getData();

                if ($licenseDriver != null)
                {
                    $file = $licenseDriver->getFile();

                    $fileName = md5(uniqid()).'.'.$file->guessExtension();

                    $file->move(
                        $this->getParameter('upload_file_directory'),
                        $fileName
                    );

                    $licenseDriver->setPath($this->getParameter('upload_file_directory') .'/'.  $fileName);

                    $em = $this->getDoctrine()->getEntityManager();
                    $em->persist($licenseDriver);
                    $em->flush();
                }

                $format = 'Y-m-d H:i:s';

                $dateStart = $request->query->get('dateStart');
                $dateStart = DateTime::createFromFormat($format, $dateStart);

                $dateEnd = $request->query->get('dateEnd');
                $dateEnd = DateTime::createFromFormat($format, $dateEnd);

                $canBooking = $reservationManager->canBooking($booking);

                if ($canBooking) {
                    $booking->setClient($user);
                    $booking->setBookingOptions($optionChoose);
                    $reservationManager->booking($booking, $car, $dateStart, $dateEnd);
                } else {
                    throw new \Exception("vous devez etre connecté ou poursuivre en tant qu'invité");
                }

                $reservationManager->save($booking);
            }
        }

        return $this->render('frontend/user/reservation.html.twig', [
            'formDate' => $formDate->createView(),
            'form1' => $form1->createView(),
            'form' => $form->createView(),
            'car' => $car,
            'priceRepository' => $priceRepository,
            'optionChoose' => $optionChoose,
            'trans_id' => $trans_id
        ]);
    }

    public function getNewTransactionId()
    {
        /** @var \AppBundle\Repository\TransactionRepository $transactionRepository */
        $transactionRepository = $this->getDoctrine()->getRepository(Transaction::class);

        $transaction = $transactionRepository->getLastTransactionId();

        $last_id = $transaction[0]["transactionId"];

        $next_id = $last_id + 1;

        return $next_id;
    }
}
