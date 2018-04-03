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
            ->add('toPay')
            ->add('createdAt')
            ;
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->with('Agence')
                //->add('client.username', 'text')
                ->add('pickUpLocationId', 'entity', array(
                    'class' => 'AppBundle\Entity\PickUpCenter',
                    'property' => 'agency.name',
                ))
                ->add('dropOffLocationId', 'entity', array(
                'class' => 'AppBundle\Entity\PickUpCenter',
                'property' => 'agency.name',
                ))
            ->end()
            ->with('Information location')
                ->add('car', 'entity', array(
                    'class' => 'AppBundle\Entity\Car',
                    'property' => 'carModel'
                ))
            ->add('dateStart', 'datetime', [
                'required' => false,
                'label' => 'Date début',
                'format'=>'YYYY-MM-DD hh:mm:ss',
                'attr' => array(
                    'data-date-format' => 'YYYY-MM-DD hh:mm:ss',
                )
            ])
            ->add('dateEnd', 'datetime', [
                'required' => false,
                'label' => 'Date fin',
                'format'=>'YYYY-MM-DD hh:mm:ss',
                'attr' => array(
                    'data-date-format' => 'YYYY-MM-DD hh:mm:ss',
                )
            ])
            ->end()
            ->with('Client')
                ->add('client')

            ->end()
            ->with('Statuts')
                ->add('createdAt', 'sonata_type_datetime_picker')
                ->add('status', 'sonata_type_translatable_choice', [
                    //'translation_domain' => 'messages',
                    'choices' => [
                        Reservation::$statuses
                    ]
                ])
            ->end();
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->add('car.carMaker')
            ->add('car.carModel')
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

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('dateStart', 'doctrine_orm_date_range')
            ->add('dateEnd', 'doctrine_orm_date_range')
            ->add('status')
            ->add('car.carMaker')
            ->add('car.carModel')
        ;
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
