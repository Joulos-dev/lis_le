<?php

namespace App\Controller;

use App\Entity\PostThumb;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use App\Repository\PostThumbRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PostController extends AbstractController
{
    #[Route('/post/show/{id}', name: 'app_post_show')]
    public function index(
        string $id,
        PostRepository $postRepository,
        CommentRepository $commentRepository,
        CategoryRepository $categoryRepository
    ): Response
    {

        $post = $postRepository->findOneBy( ['id' => $id]);

        $comments = $commentRepository->findBy(['post' => $post],['createdAt' => 'DESC'], 4);

        return $this->render('post/show.html.twig', [
            'post' => $post,
            'comments' => $comments,
        ]);
    }

    #[Route('/post/like/{id}', name: 'app_post_like')]
    public function postLike(
        string $id,
        PostRepository $postRepository,
        PostThumbRepository $postThumbRepository,
        EntityManagerInterface $entityManager,
    ): Response
    {

        $user = $this->getUser();

        $post = $postRepository->findOneBy( ['id' => $id]);
        $postThumb = $postThumbRepository->findOneBy([
            'post' => $post,
            'user' => $user
        ]);

//        dd($postThumb);

        if( $postThumb === Null) {
            $postThumb = new PostThumb();

            $postThumb->setPost($post);
            $postThumb->setUser($user);
            $postThumb->setType(true);

            $entityManager->persist($postThumb);
            $entityManager->flush();

//            return $this->json();
        }


        //sinon
            //si $postThumb->type = true
                //ne fait rien
            //sinon
                //postThumb->setType = true

        return $this->redirectToRoute('app_home');
    }

}
