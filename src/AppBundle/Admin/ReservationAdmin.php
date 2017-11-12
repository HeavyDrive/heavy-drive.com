<?php
namespace AppBundle\Admin;

use AppBundle\Entity\Reservation;
use Doctrine\DBAL\Types\TextType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Validator\Constraints\Choice;

class ReservationAdmin extends AbstractAdmin
{

    protected function configureShowFields(ShowMapper $show)
    {
        $show
            ->add('pickUpLocationId.agency.name')
            ->add('dropOffLocationId.agency.name')
            ->add('dateStart')
            ->add('dateEnd')
            ->add('createdAt')

            ;
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
        ->with('Général')
            //->add('client.username', 'text')
            ->add('pickUpLocationId', 'entity', array(
                'class' => 'AppBundle\Entity\PickUpCenter',
                'property' => 'agency.name',
            ))
            ->add('dropOffLocationId', 'entity', array(
                'class' => 'AppBundle\Entity\PickUpCenter',
                'property' => 'agency.name',
            ))
            ->add('dateStart', 'sonata_type_datetime_picker')
            ->add('dateEnd', 'sonata_type_datetime_picker')
            ->add('createdAt', 'sonata_type_datetime_picker')
            ->add('status', 'sonata_type_translatable_choice', [
                'catalogue' => 'AppBundle',
                'choices' => [
                    Reservation::$statuses
                ]
            ])
        ->end();
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->add('car.maker')
            ->add('client.username')
            ->add('pickUpLocationId.agency.name')
            ->add('dropOffLocationId.agency.name')
            ->add('status')
            ->add('dateStart')
            ->add('dateEnd')
            ->add('createdAt')
            ->add('toPay')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ));
    }

    protected $datagridValues = array(

        // display the first page (default = 1)
        '_page' => 1,

        // reverse order (default = 'ASC')
        '_sort_order' => 'DESC',

        // name of the ordered field (default = the model's id field, if any)
        '_sort_by' => 'createdAt',
    );

}
