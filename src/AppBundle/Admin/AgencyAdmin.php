<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class AgencyAdmin extends AbstractAdmin
{
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
            ->add('siret')
            ->add('tva_number')
            ->add('billing_address')
            ->add('billing_zip_code')
            ->add('billing_city')
            ->add('billing_country')
            ->add('enabled')
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('name')
                ->add('siret')
                ->add('enabled', null, array('required' => false))
            ->end()
            ->with('Informations', array('collapsed' => true))
                ->add('tva_number', 'number')
                ->add('billing_address', 'text')
                ->add('billing_zip_code', 'number')
                ->add('billing_city', 'text')
                ->add('billing_country', 'text')
            ->end()
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('enabled')
            ->add('siret')
            ->add('tva_number')
            ->add('billing_address')
            ->add('billing_zip_code')
            ->add('billing_city')
            ->add('billing_country')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show'   => array(),
                    'edit'   => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('enabled')
        ;
    }
}