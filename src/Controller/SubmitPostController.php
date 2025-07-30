<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageFormType;
use App\Repository\MessageRepository;
use App\Service\FileUploaderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SubmitPostController extends AbstractController
{

    /**
     * @param string|null $id si $id = null, alors on est en train de créer un POST, sinon c'est un MESSAGE
     * @param MessageRepository $messageRepository
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @param FileUploaderService $fileUploaderService
     * @return Response
     */
    #[Route('/submit/post/{id?}', name: 'app_submit_post')]
    public function index(
        ?string $id,
        MessageRepository $messageRepository,
        EntityManagerInterface $entityManager,
        Request $request,
        FileUploaderService $fileUploaderService
    ): Response
    {
        $isPost = $id === null;
        $message = new Message();
        $newMessageForm = $this->createForm(MessageFormType::class, $message, [
            'isPost' => $isPost
        ]);

        $newMessageForm->handleRequest($request);
        if ($newMessageForm->isSubmitted() && $newMessageForm->isValid()) {
            if ($id !== null) {
                $parentMessage = $messageRepository->findOneBy(['id' => $id]);
                $message->setParent($parentMessage);
            }

            if ($newMessageForm->has('image')) {
                $filename = $fileUploaderService->uploadFile($newMessageForm->get('image')->getData(), '/post');
                $message->setImage($filename);
            }

            $message->setUser($this->getUser());
            $message->setCreatedAt(new \DateTime());

            if ($isPost) {
                $message->setType('post');
            } else {
                $message->setType('message');
            }

            $entityManager->persist($message);
            $entityManager->flush();

            if ($isPost) {
                return $this->redirectToRoute('app_home');
            }

            $parentId = $parentMessage->getId();
            while ($parentMessage->getParent() !== null) {
                $parentMessage = $parentMessage->getParent();
                $parentId = $parentMessage->getId();
            }

            return $this->redirectToRoute('app_post_show', ['id' => $parentId]);
        }

        return $this->render('submit_post/submit.html.twig', [
            'newMessageForm' => $newMessageForm,
        ]);
    }
}
