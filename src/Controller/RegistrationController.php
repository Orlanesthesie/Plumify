<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route(path: '/registration', name: 'app_registration')]
    public function registration(Request $request, UserPasswordHasherInterface $passwordHasher, BookRepository $bookRepository, CategoryRepository $categoryRepository, EntityManagerInterface $entityManager): Response
    {
        // Créer une instance de User
        $user = new User();

        // Si le formulaire est soumis
        if ($request->isMethod('POST')) {

            // Récupérer les données du formulaire
            $firstname = $request->request->get('firstname');
            $lastname = $request->request->get('lastname');
            $email = $request->request->get('email');
            $plainPassword = $request->request->get('password');

            // Vérifier si les champs ne sont pas vides || = OU
            if (empty($firstname) || empty($lastname) || empty($email) || empty($plainPassword)) {
                // Message d'erreur si des champs sont manquants
                $this->addFlash('error', 'Tous les champs doivent être remplis.');
                return $this->render('registration/registration.html.twig');
            }

            // Validation simple de l'email (verifier si le format est valide)
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->addFlash('error', 'Veuillez entrer une adresse email valide.');
                return $this->render('registration/registration.html.twig');
            }

            // Créer et configurer l'utilisateur
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setEmail($email);
            $user->setRoles(['ROLE_USER']);

            // Hasher le mot de passe
            $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);

            // Persist et flush en base de données
            $entityManager->persist($user);
            $entityManager->flush();

            // // Message de succès
            // $this->addFlash('success', 'Inscription réussie ! Vous pouvez maintenant vous connecter.');

            // Authentifier l'utilisateur après l'inscription
            $this->security->login($user);

            $categories = $categoryRepository->findAll();
            $newBooks = $bookRepository->findBy([], ['publicationYear' => 'DESC'], 5, 0);
            $randomBooks = $bookRepository->findAll();
            shuffle($randomBooks);
            $randomBooks = array_slice($randomBooks, 0, 5);
            $popularBooks = $bookRepository->findPopularBooks();

            // Modale updtae profile
            $user = $this->getUser();
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->flush();
                $this->addFlash('success', 'Profil mis à jour avec succès');
                return $this->redirectToRoute('app_home');
            }

            return $this->render('index.html.twig', [
                'categories' => $categories,
                'newBooks' => $newBooks,
                'randomBooks' => $randomBooks,
                'popularBooks' => $popularBooks,
                'form' => $form->createView(),
            ]);
        }

        // Afficher le formulaire d'inscription
        return $this->render('registration/registration.html.twig');
    }
}
