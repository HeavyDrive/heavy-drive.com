<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('attr' => array('placeholder' => 'Prénom Nom'),
                'constraints' => array(
                    new NotBlank(array("message" => "Entrez vos nom et prénom")),
                )
            ))
            ->add('subject', TextType::class, array('attr' => array('placeholder' => 'Sujet'),
                'constraints' => array(
                    new NotBlank(array("message" => "Quel est l'objet de votre demande ?")),
                )
            ))
            ->add('email', EmailType::class, array('attr' => array('placeholder' => 'Votre adresse email'),
                'constraints' => array(
                    new NotBlank(array("message" => "Entrez une adresse email valide")),
                    new Email(array("message" => "Oups, votre email ne semble pas être valide")),
                )
            ))
            ->add('message', TextareaType::class, array('attr' => array('placeholder' => 'Votre message'),
                'constraints' => array(
                    new NotBlank(array("message" => "Ecrivez votre message ici")),
                )
            ))
        ;
    }

    public function setDefaults(OptionsResolver $resolver)
    {
        $resolver->setDefault(array(
            'error_bubbling' => true
        ));
    }

    public function getName()
    {
        return 'contact_form';
    }
}