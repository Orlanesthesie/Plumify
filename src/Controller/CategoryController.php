<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Category;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    #[Route('/category/{id}', name: 'category_show')]
    public function show(Category $category, EntityManagerInterface $entityManager, BookRepository $bookRepository, CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        $randomBooks = $bookRepository->findAll();
        shuffle($randomBooks);
        $randomBooks = array_slice($randomBooks, 0, 5);

        // Récupérer les livres associés à cette catégorie
        $books = $category->getBooks();

        if ($books->isEmpty()) {
            throw new \Exception("No books found in this category.");
        }

        return $this->render('category/show.html.twig', [
            'category' => $category,
            'categories' => $categories,
            'books' => $books,
            'randomBooks' => $randomBooks,
        ]);
    }
}
