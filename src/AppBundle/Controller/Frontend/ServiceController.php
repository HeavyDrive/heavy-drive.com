<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ServiceController extends Controller
{
    /**
     * @Route("/services", name="service")
     *
     */
    public function listServiceAction(){

        return $this->render('frontend/default/service.html.twig', []);
    }
    /**
     * @Route("/wedding", name="wedding")
     *
     * @return Response
     */
    public function weddingAction(Request $request){

        $form = $this->get('form.factory')->createBuilder()
            ->add('agency', 'entity', array(
                    'class' => 'AppBundle:Agency',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('a')
                            ->groupBy('a.id')
                            ->orderBy('a.name', 'ASC');
                    },)
            )
            ->add('agencyRetour', 'entity', array(
                    'class' => 'AppBundle:Agency',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('a')
                            ->groupBy('a.id')
                            ->orderBy('a.name', 'ASC');
                    },)
            )
            ->add('startDate', DateTimeType::class, [
                'data' => new \DateTime('now'), //default value
                'format' => 'dd-MM-yyyy HH:mm:ss',
                'model_timezone' => 'Europe/Paris',
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker1 form-control'],
            ])
            ->add('endDate', DateTimeType::class, [
                'data' => new \DateTime('now'), //default value
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy HH:mm:ss',
                'model_timezone' => 'Europe/Paris',
                'attr' => ['class' => 'js-datepicker2 form-control'],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Rechercher votre véhicule',
                'attr' => array('class' => 'btn btn-default'),
            ])->getForm();

        $form->handleRequest($request);

        $agency = $form->get('agency')->getData();
        $dateStart =  $form->get('startDate')->getData();
        $dateEnd = $form->get('endDate')->getData();

        $cars = array();


        if ($form->isValid() && $form->isSubmitted()) {

            $em = $this->getDoctrine()->getManager(); // ...or getEntityManager() prior to Symfony 2.1

            $query = $em->createQuery("SELECT DISTINCT c.id, r.dateStart, r.dateEnd
                                       FROM AppBundle:Car c 
                                       JOIN AppBundle:Reservation r 
                                       WHERE c.id = r.car 
                                       AND r.dateStart <= :dateStart AND r.dateEnd >= :dateEnd
                                       OR r.dateStart > :dateStart AND r.dateEnd <= :dateEnd
                                       OR r.dateStart > :dateStart AND r.dateEnd = :dateEnd                                
                                      ");
            $query->setParameter('dateStart', $dateStart);
            $query->setParameter('dateEnd', $dateEnd);

            $listCars = $query->getResult();

            /** @var \AppBundle\Repository\CarRepository $carRepository */
            $carRepository = $this->getDoctrine()->getRepository(Car::class);

            if (!$listCars) {
                $cars = $carRepository->findAll();
            }
            else {
                $cars = $carRepository->getWhatYouWant($listCars);
            }
        }

        return $this->render('frontend/default/wedding.html.twig', ['form' => $form->createView()]);
    }
}
