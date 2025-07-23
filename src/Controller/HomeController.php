<?php

namespace App\Controller;

use App\Entity\PostThumb;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use App\Repository\PostThumbRepository;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
//        string $id,
        PostRepository $postRepository,
        PostThumbRepository $postThumbRepository,


    ): Response
    {

//        $thumbType = $postThumbRepository->findOneBy( ['id' => $id]);
//


        $lastPost = $postRepository->findBy(
            [],
            ['createdAt' => 'DESC'],
            5
        );

        dump($lastPost);

        return $this->render('home/index.html.twig', [
            'lastPost' => $lastPost,
//            'thumbType' => $thumbType
        ]);
    }
}
