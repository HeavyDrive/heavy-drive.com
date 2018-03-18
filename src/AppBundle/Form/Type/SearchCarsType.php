<?php
/**
 * Created by PhpStorm.
 * User: ashley
 * Date: 11/03/18
 * Time: 21:21
 */

namespace AppBundle\Form\Type;


use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchCarsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
                'attr' => array('class' => 'btn btn-primary'),
            ]);
    }
}