<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\UserType;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CategoryRepository $categoryRepository, BookRepository $bookRepository,
     Request $request, EntityManagerInterface $entityManager): Response
    {
        $newBooks = $bookRepository->findBy([], ['publicationYear' => 'DESC'], 5, 0);
        // dd($newBooks);
        $categories = $categoryRepository->findAll();

        $randomBooks = $bookRepository->findAll();
        shuffle($randomBooks);
        $randomBooks = array_slice($randomBooks, 0, 5);

        $popularBooks = $bookRepository->findPopularBooks();

        // Modale update profile
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Profile updated successfully');
            return $this->redirectToRoute('app_home');
        }

        $user = $this->getUser();

        return $this->render('index.html.twig', [
            'categories' => $categories,
            'newBooks' => $newBooks,
            'randomBooks' => $randomBooks,
            'popularBooks' => $popularBooks,
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }


    #[Route('/book/{id}', name: 'book_show', methods: ['GET'])]
    public function show(Book $book, CategoryRepository $categoryRepository, EntityManagerInterface $entityManager, BookRepository $bookRepository, Request $request): Response
    {
        $categories = $categoryRepository->findAll();
        $randomBooks = $bookRepository->findAll();
        shuffle($randomBooks);
        $randomBooks = array_slice($randomBooks, 0, 5);
        $category = $book->getCategory();
        // dd($book->getLikedByUsers());
        // $relatedBooks; 
        $user = $this->getUser();


        // Modale update profile
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Profile updated successfully');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('book/show.html.twig', [
            'categories' => $categories,
            'book' => $book,
            'randomBooks' => $randomBooks,
            'form' => $form->createView(),
            // 'relatedBooks' => $relatedBooks,
            'user' => $user,

        ]);
    }

    #[Route('/book/{id}/like', name: 'book_like', methods: ['POST'])]
    public function like(Book $book, EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $this->getUser();

        // Vérifie si l'utilisateur est connecté
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return new JsonResponse([
                'error' => "You must be logged in to like a book. Please sign up or log in."], 403);
            
        }

        // Si l'utilisateur a déjà liké ce livre, on enlève le like
        if ($book->isLikedByUser($user)) {
            $book->removeLikedByUser($user);
        } else {
            // Sinon, on ajoute le like
            $book->addLikedByUser($user);
        }

        $entityManager->flush();

        return new JsonResponse(['likes' => $book->getLikedByUsers()->count()]);
    }


    #[Route('/search', name: 'book_search', methods: ['GET', 'POST'])]
    public function search(Request $request, EntityManagerInterface $entityManager, BookRepository $bookRepository, CategoryRepository $categoryRepository): Response
    {
        $searchTerm = $request->query->get('query');  // Récupérer la recherche de l'utilisateur
        $categories = $categoryRepository->findAll();

        $randomBooks = $bookRepository->findAll();
        shuffle($randomBooks);
        $randomBooks = array_slice($randomBooks, 0, 5);

        $user = $this->getUser();

        // Modale update profile
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Profile updated successfully');
            return $this->redirectToRoute('app_home');
        }

        
        // Rechercher dans la base de données par titre
        $books = $entityManager->getRepository(Book::class)->createQueryBuilder('b')
        ->where('b.title LIKE :searchTerm')
        ->setParameter('searchTerm', '%' . $searchTerm . '%')
        ->getQuery()
        ->getResult();
        
        // dd($books);
        return $this->render('search/search_results.html.twig', [
            'categories' => $categories,
            'books' => $books,
            'searchTerm' => $searchTerm,
            'randomBooks' => $randomBooks,
            'form' => $form->createView(),
            'user' => $user,

        ]);
    }

}
