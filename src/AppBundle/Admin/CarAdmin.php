<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CarAdmin extends AbstractAdmin
{

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('uuid')
            ->add('registration')
            ->add('firstRegistrationAt')
            ->add('enabled')
            ->add('status')
            ->add('pickUpStatus')
            ->add('pickUpDoneAt')
            ->add('carType')
            ->add('carEnergyType')
            ->add('carMaker')
            ->add('carCnit')
            ->add('carModel')
            ->add('carModelVariant')
            ->add('carEngine')
            ->add('firstHand')
            ->add('duplicateKeys')
            ->add('interiorColor')
            ->add('exteriorColor')
            ->add('passengerCapacity')
            ->add('doors')
            ->add('transmission')
            ->add('mileageReal')
            ->add('mileageEstimate')
            ->add('lastMaintenanceMileage')
            ->add('chassisJig')
            ->add('repainted')
            ->add('options', 'array')
            ->add('pictures', 'array')
            ->add('comments')
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Général')
                ->add('uuid', 'text')
                ->add('carCnit', 'text', [
                    'required' => false
                ])
                ->add('registration', 'text')
                ->add('firstRegistrationAt', 'sonata_type_datetime_picker', [
                    'data' => new \DateTime(), 'required' => false
                ])
                ->add('enabled', null, array('required' => false))
            ->end()
            ->with('Informations', array('collapsed' => true))
                ->add('status', 'text')
                ->add('pickUpStatus', 'text')
                ->add('pickUpDoneAt', 'sonata_type_datetime_picker', [
                    'data' => new \DateTime(), 'required' => false
                ])
            ->end()
            ->with('Fiche technique', array('collapsed' => true))
                ->add('carType', 'text', [
                    'required' => false
                ])
                ->add('carEnergyType', 'text', [
                    'required' => false
                ])
                ->add('carMaker', 'text', [
                    'required' => false
                ])
                ->add('carModel', 'text', [
                    'required' => false
                ])
                ->add('carModelVariant', 'text', [
                    'required' => false
                ])
                ->add('carEngine', 'text', [
                    'required' => false
                ])
                ->add('transmission', 'text', [
                    'required' => false
                ])
                ->add('chassisJig', null, [
                    'required' => false
                ])
            ->end()
            ->with('Kilométrage', array('collapsed' => true))
                ->add('mileageReal', 'text', [
                    'required' => false
                ])
                ->add('mileageEstimate', 'text', [
                    'required' => false
                ])
                ->add('lastMaintenanceMileage', 'text', [
                    'required' => false
                ])
            ->end()
            ->with('Détails du véhicule', array('collapsed' => true))
                ->add('interiorColor', 'text', [
                    'required' => false
                ])
                ->add('exteriorColor', 'text', [
                    'required' => false
                ])
                ->add('passengerCapacity', 'text', [
                    'required' => false
                ])
                ->add('doors', 'text', [
                    'required' => false
                ])
                ->add('firstHand', null, [
                    'required' => false
                ])
                ->add('duplicateKeys', null, [
                    'required' => false
                ])
                ->add('repainted', null, [
                    'required' => false
                ])
                ->add('options', 'text', [
                    'required' => false
                ])
                ->add('pictures', 'text', [
                    'required' => false
                ])
            ->end()
            ->with('System Information', array('collapsed' => true))
                ->add('createdAt', 'sonata_type_datetime_picker', [
                    'data' => new \DateTime(), 'required' => false
                ])
                ->add('updatedAt', 'sonata_type_datetime_picker', [
                    'data' => new \DateTime(), 'required' => false
                ])
            ->end()
            ->with('Comments')
                ->add('comments')
            ->end();
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('uuid')
            ->add('enabled')
            ->add('registration')
            ->add('firstRegistrationAt')
            ->add('carType')
            ->add('carEnergyType')
            ->add('carModel')
            ->add('interiorColor')
            ->add('exteriorColor')
            ->add('passengerCapacity')
            ->add('doors')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('enabled');
    }
}
