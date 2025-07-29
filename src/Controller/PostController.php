<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Reaction;
use App\Repository\MessageRepository;
use App\Repository\ReactionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\CreateMessage;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class PostController extends AbstractController
{

    #[Route('/message/show/{id}', name: 'app_post_show')]
    public function index(
        string                 $id,
        MessageRepository      $messageRepository,
        Request                $request,
        EntityManagerInterface $entityManager,
    ): Response
    {
        $post = $messageRepository->findOneBy(['id' => $id]);

        $comment = new Message();
        $form = $this -> createForm(CreateMessage::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($comment);
            $entityManager->flush();
            return $this->redirectToRoute('app_post_show');
        }

        return $this->render('post/show.html.twig', [
            'post' => $post,
            'commentForm' => $form,
        ]);
    }

    #[Route('/make-reaction/{id}/{type}', name: 'app_make_reaction', methods: ['POST'])]
    public function makeReaction(
        string $id,
        int $type,
        UrlGeneratorInterface $generator,
        MessageRepository $messageRepository,
        ReactionRepository $reactionRepository,
        EntityManagerInterface $em
    ): JsonResponse
    {
        $message = $messageRepository->find($id);
        $user = $this->getUser();
        // Génère route de login
        $redirectLogin = $generator->generate('app_login');

        if (!$user) {
            return new JsonResponse(['login' => $redirectLogin]);
        }

        $existingReaction = $reactionRepository->findOneBy([
            'message' => $message,
            'user' => $user,
        ]);

        $messageLiked = $type;
        if ($existingReaction === null) {
            $existingReaction = (new Reaction())
                ->setUser($user)
                ->setMessage($message)
                ->setType($type === 1)
                ->setCreatedAt(new \DateTime());

            $em->persist($existingReaction);
        } else {
            if (intval($existingReaction->isType()) === $type) {
                $em->remove($existingReaction);
                $messageLiked = null;
            } else {
                $existingReaction->setType($type);
            }
        }

        $em->flush();

        $block = $this->renderView('_partials/_block_likes.html.twig', [
            'post' => $message,
            'messageLiked' => $messageLiked,
        ]);

        return new JsonResponse([
            'block' => $block,
            'messageId' => $message->getId(),
        ]);
    }


//        $post = $postRepository->findOneBy( ['id' => $id]);
//        $postThumb = $postThumbRepository->findOneBy([
//            'post' => $post,
//            'user' => $user
//        ]);
//
//        if( $postThumb === Null) {
//            $postThumb = new PostThumb();
//
//            $postThumb->setPost($post);
//            $postThumb->setUser($user);
//            $postThumb->setType(true);
//
//            $entityManager->persist($postThumb);
//        } else {
//            if($postThumb->isType() === true ) {
//                $entityManager->remove($postThumb);
//            } else {
//                $postThumb->setType(true);
//                $entityManager->persist($postThumb);
//            }
//        }
//
//        $entityManager->flush();
//        return $this->redirectToRoute('app_home');
//    }

//
//    #[Route('/post/dislike/{id}', name: 'app_post_dislike')]
//    public function postDislike(
//        string $id,
//        PostRepository $postRepository,
//        PostThumbRepository $postThumbRepository,
//        EntityManagerInterface $entityManager,
//    ): Response
//    {
//
//        $user = $this->getUser();
//
//        $post = $postRepository->findOneBy( ['id' => $id]);
//        $postThumb = $postThumbRepository->findOneBy([
//            'post' => $post,
//            'user' => $user
//        ]);
//
//        if( $postThumb === Null) {
//            $postThumb = new PostThumb();
//
//            $postThumb->setPost($post);
//            $postThumb->setUser($user);
//            $postThumb->setType(false);
//
//            $entityManager->persist($postThumb);
//        } else {
//            if($postThumb->isType() === false ) {
//                $entityManager->remove($postThumb);
//            } else {
//                $postThumb->setType(false);
//                $entityManager->persist($postThumb);
//            }
//        }
//
//        $entityManager->flush();
//        return $this->redirectToRoute('app_home');
//    }


}


