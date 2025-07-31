<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CategoryController extends AbstractController
{
    #[Route('/category/{id}', name: 'app_post_category')]
    public function index(
        string $id,
        CategoryRepository $categoryRepository,
    ): Response
    {
       $category = $categoryRepository->find($id);


        return $this->render('category/posts.html.twig', [
            'category' => $category
        ]);
    }
}
