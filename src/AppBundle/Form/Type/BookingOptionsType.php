<?php
/**
 * Created by PhpStorm.
 * User: ashley
 * Date: 30/08/17
 * Time: 19:56
 */

namespace AppBundle\Form\Type;


use AppBundle\Entity\BookingOptions;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingOptionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
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
                'attr'=> array('class' => 'btn btn-default')
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => BookingOptions::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'Symfony\Component\Form\Extension\Core\Type\FormType';
    }
}