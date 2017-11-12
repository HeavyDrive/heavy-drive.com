<?php
/**
 * Created by PhpStorm.
 * User: ashley
 * Date: 16/08/17
 * Time: 14:19
 */

namespace AppBundle\Form\Type;


use AppBundle\Entity\PickUpCenter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IdentityCardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('path')
            ->add('name', 'text', [
                'attr' => array('class' => 'form-control')
            ])
            ->add('file', 'file', [
                'multiple' => false,
                'data_class' => null,
                'attr' => array('class' => 'btn btn-primary')

            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => PickUpCenter::class
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