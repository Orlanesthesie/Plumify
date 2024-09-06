<?php

namespace App\Controller;

use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
