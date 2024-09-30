<?php

namespace App\Controller;

use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModalTestController extends AbstractController
{
    #[Route('/modal-test', name: 'modal_test')]
    public function index(): Response
    {
        return $this->render('modal_test/modal_test.html.twig');
    }
}
