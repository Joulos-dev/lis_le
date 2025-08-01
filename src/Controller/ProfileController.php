<?php

namespace App\Controller;

use App\Repository\MessageRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ProfileController extends AbstractController
{
    #[Route('/profile/{id}', name: 'app_profile')]
    public function index(
        string $id,
        MessageRepository $messageRepository,
        UserRepository $userRepository,
    ): Response
    {

        $profile = $userRepository->find($id);

        dump($profile);

        $userPosts = $messageRepository->findBy(
            ['type' => 'post', 'user' => $id],
            ['createdAt' => 'ASC'],
        );


        $userComments = $messageRepository->findBy(
            ['type' => 'message', 'user' => $id],
            ['createdAt' => 'ASC'],
        );


        return $this->render('profile/profile.html.twig', [
            'userPosts'=> $userPosts,
            'userComments'=> $userComments,
            'profile' => $profile,
        ]);
    }
}
