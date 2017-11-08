<?php
/**
 * Created by PhpStorm.
 * User: ashley
 * Date: 30/08/17
 * Time: 19:56
 */

namespace AppBundle\Form\Type;


use AppBundle\Entity\BookingOptions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingOptionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', CheckboxType::class, [
                'attr' => array('class' => 'form-control')
            ]);
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