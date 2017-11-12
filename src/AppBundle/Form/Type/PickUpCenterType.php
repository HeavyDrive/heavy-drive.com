<?php
/**
 * Created by PhpStorm.
 * User: ashley
 * Date: 09/08/17
 * Time: 14:42
 */

namespace AppBundle\Form\Type;


use AppBundle\Entity\PickUpCenter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PickUpCenterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id')
            ->add('agency', 'entity', [
               'class' => 'AppBundle:Agency',
               'property' => 'name',
               'multiple' => false
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