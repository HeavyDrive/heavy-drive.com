<?php
/**
 * Created by PhpStorm.
 * User: hd
 * Date: 14/02/18
 * Time: 11:29
 */

namespace AppBundle\Form\Type;


use AppBundle\Entity\Transaction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SystemPayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('amount');
        $builder->add('currency');
        $builder->add('save', SubmitType::class, [
        'label' => 'valider',
        'attr' => array('class' => 'btn btn-default'),
    ]);
    }

    /**
    * @param OptionsResolver $resolver
    */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Transaction::class
        ));
    }
}