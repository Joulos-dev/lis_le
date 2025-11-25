<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Reaction;
use App\Form\MessageFormType;
use App\Repository\MessageRepository;
use App\Repository\ReactionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class PostController extends AbstractController
{

    #[Route('/message/show/{id}', name: 'app_post_show')]
    public function index(
        string                 $id,
        MessageRepository      $messageRepository,
    ): Response
    {
        // le findFullById est un query builder créer a la main dans MessageRepository
        $post = $messageRepository->findFullById($id);
        $message = new Message();
        $newMessageForm = $this->createForm(MessageFormType::class, $message, [
            'isPost' => false
        ]);

        return $this->render('post/show.html.twig', [
            'post' => $post,
            'newMessageForm' => $newMessageForm,
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

            //INSERT INTO reaction(user_id, message_id, type, created_at)
            //VALUES(2, 3, 1, '2025-01-01')
        } else {
            if (intval($existingReaction->isType()) === $type) {
                // si il clique sur "like" et que le type actuelle est aussi like
                // en sql >>> DELETE FROM reaction WHERE id = x
                $em->remove($existingReaction);
                // alors on l'enlève
                $messageLiked = null;
            } else {
                $existingReaction->setType($type);
                // sinon on met l'inverse
                // en sql >>> UPDATE FROM reaction SET type = *new type* WHERE id = x
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

    #[Route('/delete/{id}', name: 'app_delete')]
    public function deletePost(
        string                 $id,
        MessageRepository      $messageRepository,
        EntityManagerInterface $entityManager,
    ): Response
    {

        $user = $this->getUser();

        /** @var Message $message */
        $message = $messageRepository->find($id);

        if($user->getId()=== $message->getUser()->getId() ) {
            $entityManager->remove($message);
            $entityManager->flush();
        } else {
            return $this->redirectToRoute('app_login');
        }

        return $this->redirectToRoute('app_home');
    }

//    #[Route('/edit/{id}', name: 'app_edit')]
//    public function editPost(
//        string                 $id,
//        MessageRepository      $messageRepository,
//        EntityManagerInterface $entityManager,
//    ): Response
//    {
//
//        $message = $messageRepository->find($id);
//        $entityManager->persist($message);
//        $entityManager->flush();
//
//        return $this->render('home/admin_list.html.twig', [
//            'message' => $message,
//        ]);
//    }

}


