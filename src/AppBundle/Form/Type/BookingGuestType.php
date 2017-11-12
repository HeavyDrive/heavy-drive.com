<?php
/**
 * Created by PhpStorm.
 * User: ashley
 * Date: 11/08/17
 * Time: 14:43
 */

namespace AppBundle\Form\Type;


use AppBundle\Entity\BookingGuest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingGuestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', 'text', [
                'attr' => array('class' => 'form-control')
            ])
            ->add('lastName', 'text', [
                'attr' => array('class' => 'form-control')
            ])
            ->add('telephone', 'text', [
                'attr' => array('class' => 'form-control')
            ])
            ->add('city', 'text', [
                'attr' => array('class' => 'form-control')
            ])
            ->add('address', 'text', [
                'attr' => array('class' => 'form-control')
            ])
            ->add('zipCode', 'text', [
                'attr' => array('class' => 'form-control')
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistré',
                'attr'=> array('class' => 'btn btn-default')
            ]);

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => BookingGuest::class
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