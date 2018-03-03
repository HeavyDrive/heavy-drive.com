<?php
/**
 * Created by PhpStorm.
 * User: hd
 * Date: 02/03/18
 * Time: 11:20
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class FormStyleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
        $builder->add('phone', 'number');
        $builder->add('email', 'email');
        $builder->add('subject');
        $builder->add('message', 'textarea');
    }

    public function getName()
    {
        return 'contact';
    }
}