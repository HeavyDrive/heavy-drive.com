<?php

namespace AppBundle\Form;

use AppBundle\Entity\BookingOptions;
use AppBundle\Entity\PickUpCenter;
use AppBundle\Entity\Reservation;
use AppBundle\Form\Type\BookingOptionsType;
use AppBundle\Form\Type\IdentityCardType;
use AppBundle\Form\Type\LicenseDriverType;
use AppBundle\Form\Type\PickUpCenterType;
use AppBundle\Form\Type\ProofOfAddress;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;

class SelectedBookingDate extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('licenceDriver', new LicenseDriverType(), [
                'required' => false
            ])
            ->add('IdentityCard', new IdentityCardType(), [
                'required' => false
            ])
            ->add('proofOfAdress', new ProofOfAddress(), [
                'required' => false
            ])
            ->add('save', SubmitType::class, [
                'label' => 'valider',
                'attr' => array('class' => 'btn btn-default'),
            ])

        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Reservation::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'Symfony\Component\Form\Extension\Core\Type\FormType';
    }

}