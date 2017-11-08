<?php
/**
 * Created by PhpStorm.
 * User: ashley
 * Date: 12/08/17
 * Time: 15:49
 */

namespace AppBundle\Form\Type;


use AppBundle\Entity\LicenseDriver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LicenseDriverType extends AbstractType
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

            ])
            ->remove('nephNumber');
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => LicenseDriver::class
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