<?php
/**
 * Created by PhpStorm.
 * User: hd
 * Date: 14/02/18
 * Time: 11:29
 */

namespace AppBundle\Form\Type;


class SystemPayType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
        $builder->add('phone', 'number');
        $builder->add('email', 'email');
    }
}