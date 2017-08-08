<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Agency;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ClientAdmin extends AbstractAdmin
{
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('email')
            ->add('firstName')
            ->add('lastName')
            ->add('telephone')
            ->add('lastLogin')
            /*->add('username')
            ->add('usernameCanonical')
            ->add('email')
            ->add('emailCanonical')
            ->add('enabled')
            ->add('salt')
            ->add('password')
            ->add('plainPassword')
            ->add('lastLogin')
            ->add('confirmationToken')
            ->add('passwordRequestedAt')
            ->add('groups')
            ->add('locked')
            ->add('expired')
            ->add('expiresAt')
            ->add('roles')
            ->add('credentialsExpired')
            ->add('credentialsExpireAt')*/
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Général')
                //->add('Agency', 'sonata_type_model_list')
                ->add('email', 'text', [
                    'required' => false
                ])
                ->add('firstName', 'text')
                ->add('lastName', 'text')
                ->add('telephone', 'text')
                ->add('lastLogin', 'sonata_type_datetime_picker', [
                    'data' => new \DateTime(), 'required' => false
                ])
                //->add('enabled', null, array('required' => false))
            ->end()
            ->with('Security', array('collapsed' => true))
                ->add('plainPassword', 'text')
            ->end()
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('email')
            ->add('firstName')
            ->add('lastName')
            ->add('telephone')
            ->add('enabled')
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
        ;
    }
}