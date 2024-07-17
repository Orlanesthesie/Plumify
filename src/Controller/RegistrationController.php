<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    #[Route(path: '/registration', name: 'app_registration')]
    public function registration(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        //  user creation
        if ($request->isMethod('POST')) {
            // dd($request);
            // Retrieve form data
            $firstname = $request->request->get('firstname');
            $plainPassword = $request->request->get('password');

            // Create a new User entity
            $user = new User();
            $user->setFirstname($firstname);

            // Hash the plain password
            $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);

            // Persist the user entity
            $entityManager->persist($user);
            $entityManager->flush();

            // Redirect to a success page or do something else
            return $this->redirectToRoute('app_book');
        }

        // Render the registration form
        return $this->render('registration/registration.html.twig');
    }
}
