<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\UserType;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    #[Route('/category/{id}', name: 'category_show')]
    public function show(Category $category, EntityManagerInterface $entityManager, Request $request, BookRepository $bookRepository, CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        $randomBooks = $bookRepository->findAll();
        shuffle($randomBooks);
        $randomBooks = array_slice($randomBooks, 0, 5);

        // Récupérer les livres associés à cette catégorie
        $books = $category->getBooks();

        $user = $this->getUser();

        if ($books->isEmpty()) {
            throw new \Exception("No books found in this category.");
        }

        // Modale update profile
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Profile updated successfully');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('category/show.html.twig', [
            'category' => $category,
            'categories' => $categories,
            'books' => $books,
            'randomBooks' => $randomBooks,
            'form' => $form->createView(),
            'user' => $user,

        ]);
    }
}
