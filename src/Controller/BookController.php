<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CategoryRepository $categoryRepository, BookRepository $bookRepository, AuthorRepository $authorRepository): Response
    {
        $newBooks = $bookRepository->findBy([], ['publicationYear' => 'DESC'], 5, 0);
        // dd($newBooks);
        $categories = $categoryRepository->findAll();

        return $this->render('index.html.twig', [
            'categories' => $categories,
            'newBooks' => $newBooks
        ]);
    }

    #[Route('/book', name: 'app_book')]
    public function book(BookRepository $bookRepository): Response
    {
        $book = $bookRepository->findOneBy([]);

        return $this->render('book/index.html.twig', [
            'controller_name' => 'bookController',
        ]);
    }

    #[Route('/book/{id}', name: 'book_show', methods: ['GET'])]
    public function show(Book $book, CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('book/show.html.twig', [
            'categories' => $categories,
            'book' => $book,
        ]);
    }

    #[Route('/book/{id}/like', name: 'book_like', methods: ['POST'])]
    public function like(Book $book, EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $this->getUser();

        // Vérifie que l'utilisateur est bien authentifié
        // if (!$this->isGranted('ROLE_USER')) {
        //     return $this->json(['message' => 'Unauthorized'], JsonResponse::HTTP_UNAUTHORIZED);
        // }

        // Ajouter ou retirer un like en fonction de l'état actuel
        if ($book->getLikedByUsers()->contains($user)) {
            $book->removeLikedByUser($user);
        } else {
            $book->addLikedByUser($user);
        }

        $entityManager->flush();

        // Retourner le nombre total de likes en JSON
        return $this->json([
            'likes' => count($book->getLikedByUsers()),
        ]);
    }

    #[Route('/search', name: 'book_search', methods: ['GET', 'POST'])]
    public function search(Request $request, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository): Response
    {
        $searchTerm = $request->query->get('query');  // Récupérer la recherche de l'utilisateur
        $categories = $categoryRepository->findAll();

        // Rechercher dans la base de données par titre
        $books = $entityManager->getRepository(Book::class)->createQueryBuilder('b')
            ->where('b.title LIKE :searchTerm')
            ->setParameter('searchTerm', '%' . $searchTerm . '%')
            ->getQuery()
            ->getResult();

        return $this->render('search/search_results.html.twig', [
            'categories' => $categories,
            'books' => $books,
            'searchTerm' => $searchTerm
        ]);
    }
}
