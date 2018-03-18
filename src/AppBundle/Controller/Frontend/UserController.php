<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Client;
use AppBundle\Form\Type\UserEditType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @Route("/connection", name="connection")
     *
     */
    public function connectionAction(){

        return $this->render('frontend/user/connection.html.twig');
    }

    /**
     * @Route("/registration", name="Registration")
     *
     */
    public function registrationAction(Request $request){

        // 1) build the form
        $user = new Client();
        $form = $this->createForm(UserEditType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('replace_with_some_route');
        }

        return $this->render(
            'registration/register.html.twig',
            array('form' => $form->createView())
        );

        return $this->render('frontend/user/register.html.twig');
    }

}