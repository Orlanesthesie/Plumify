<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\User;
use App\Entity\Loan;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use App\Repository\LoanRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class LoanController extends AbstractController
{
    #[Route('/admin/loan/new', name: 'admin_loan_new')]
    #[IsGranted('ROLE_ADMIN')] // Seuls les admins peuvent accéder à cette route
    public function newLoan(BookRepository $bookRepository, UserRepository $userRepository, Request $request, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository): Response
    {
        //Récuperer la liste des catégories des livres
        $searchTerm = $request->query->get('query');  // Récupérer la recherche de l'utilisateur
        $categories = $categoryRepository->findAll();
        $randomBooks = $bookRepository->findRandomBooks(5);

        // Récupérer la liste des livres disponibles à l'emprunt
        $availableBooks = $bookRepository->findBy(['available' => true]);

        // Récupérer la liste de tous les utilisateurs
        $users = $userRepository->findAll();

        // Si le formulaire est soumis
        if ($request->isMethod('POST')) {
            $bookId = $request->request->get('book');
            $userId = $request->request->get('user');

            // Récupérer le livre et l'utilisateur sélectionnés
            $book = $bookRepository->find($bookId);
            $user = $userRepository->find($userId);

            if ($book && $user) {
                // Créer un nouveau prêt
                $loan = new Loan();
                $loan->setBook($book);
                $loan->setUser($user);
                // $loan->setStartDate(new \DateTime());

                // Marquer le livre comme non disponible
                $book->setAvailable(false);

                // Persister les données dans la base de données
                $entityManager->persist($loan);
                $entityManager->persist($book);
                $entityManager->flush();

                // Rediriger ou afficher un message de succès
                return $this->redirectToRoute('admin_loan_list'); // Ou une autre route après le prêt
            }
        }

        return $this->render('admin/loan/new.html.twig', [
            'availableBooks' => $availableBooks,
            'users' => $users,
            'categories' => $categories,
            'searchTerm' => $searchTerm,
            'randomBooks' => $randomBooks
        ]);
    }

    #[Route('/admin/loan/list', name: 'admin_loan_list')]
    #[IsGranted('ROLE_ADMIN')] // Seuls les admins peuvent accéder à cette route
    public function listLoans(LoanRepository $loanRepository, BookRepository $bookRepository, CategoryRepository $categoryRepository, Request $request): Response
    {
        $searchTerm = $request->query->get('query');  // Récupérer la recherche de l'utilisateur
        $categories = $categoryRepository->findAll();
        $randomBooks = $bookRepository->findRandomBooks(5);

        // Récupérer tous les prêts en cours (où endDate est null)
        $activeloans = $loanRepository->findBy(['returnDate' => null]);

        // Récupérer tous les prêts terminés (où returnDate n'est pas null)
        $pastloans = $loanRepository->findBy(['returnDate' => ['IS NOT NULL']]);

        // $loans = $loanRepository->findAll();
        // dd($loans);

        return $this->render('admin/loan/list.html.twig', [
            'activeloans' => $activeloans,
            'pastloans' => $pastloans,
            'categories' => $categories,
            'searchTerm' => $searchTerm,
            'randomBooks' => $randomBooks
        ]);
    }
}
