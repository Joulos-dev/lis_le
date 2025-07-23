<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        PostRepository $postRepository,
        CategoryRepository $categoryRepository
    ): Response
    {
        $lastPost = $postRepository->findBy(
            [],
            ['createdAt' => 'DESC'],
            5
        );

//       $category = $categoryRepository->findAll();

        return $this->render('home/index.html.twig', [
            'lastPost' => $lastPost,
//            'categories' => $category
        ]);
    }
}
