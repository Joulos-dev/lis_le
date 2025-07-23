<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CategoryController extends AbstractController
{
    #[Route('/category/{id}', name: 'app_post_category')]
    public function index(
        string $id,
        PostRepository $postRepository,
        CategoryRepository $categoryRepository,
    ): Response
    {

       $category = $categoryRepository->find($id);

       $posts = $postRepository->findBy(['category' => $category],['createdAt' => 'DESC']);

        return $this->render('category/posts.html.twig', [
            'posts' => $posts,
            'category' => $category

        ]);
    }
}
