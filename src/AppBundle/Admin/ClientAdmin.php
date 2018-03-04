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
            //->add('roles', 'collection')
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
            ->add('credentialsExpired')
            ->add('credentialsExpireAt')*/
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {

        $container = $this->getConfigurationPool()->getContainer();
        $roles = $container->getParameter('security.role_hierarchy.roles');

        $rolesChoices = self::flattenRoles($roles);

        $formMapper
            ->with('Général')
            ->add('username', 'text')
            ->add('firstName', 'text')
            ->add('lastName', 'text')
            ->add('email', 'text', [
                'required' => false
            ])
            ->add('address', 'text', [
                'required' => false
            ])
            ->add('zipcode', 'text', [
                'required' => false
            ])
            ->add('city', 'text', [
                'required' => false
            ])
            ->add('telephone', 'text')
            ->add('enabled', null)
            ->add('lastLogin', 'sonata_type_datetime_picker', [
                'data' => new \DateTime(), 'required' => false
            ])

            //->add('enabled', null, array('required' => false))
            ->end()
            ->with('Security', array('collapsed' => true))
            ->add('plainPassword', 'text', [
                'required' => false
            ])
            ->add('roles', 'choice', array(
                    'choices'  => $rolesChoices,
                    'multiple' => true,
                    'expanded' => true
                )
            )
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

    protected static function flattenRoles($rolesHierarchy)
    {
        $flatRoles = array();
        foreach($rolesHierarchy as $roles) {

            if(empty($roles)) {
                continue;
            }

            foreach($roles as $role) {
                if(!isset($flatRoles[$role])) {
                    $flatRoles[$role] = $role;
                }
            }
        }

        return $flatRoles;
    }
}