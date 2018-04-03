<?php
/**
 * Created by PhpStorm.
 * User: ashley
 * Date: 04/03/18
 * Time: 19:33
 */

namespace AppBundle\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PriceAdmin extends AbstractAdmin
{

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {

        $formMapper
            ->with('Général')
            ->add('service', 'entity', array(
                'class' => 'AppBundle\Entity\Service',
                'property' => 'name'
            ))
            ->add('car', 'entity', array(
                'class' => 'AppBundle\Entity\Car',
                'property' => 'carModel'
            ))
            ->add('to_pay', 'text', [
                'label' => "Prix caution"
            ])
            ->add('totalPrice', 'text', [
                'label' => "Prix"
            ])
            ->add('createdAt', 'sonata_type_datetime_picker')
            ->end()
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('service')
            ->add('car.carMaker')
            ->add('car.carModel')
            ->add('to_pay', 'text', [
                'label' => "Prix caution"
            ])
            ->add('totalPrice', 'text', [
                'label' => "Prix"
            ])

            ->add('_action', 'actions', array(
                'actions' => array(
                    //'show'   => array(),
                    'edit'   => array(),
                    'delete' => array(),
                )
            ))
        ;
    }
}