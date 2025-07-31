<?php

namespace App\Controller;

use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{

    #[Route('/', name: 'app_home')]
    public function index(MessageRepository $messageRepository, Request $request): Response
    {





        $searchQuery = $request->query->get('recherche'); // Récupère la valeur du champ 'recherche'

        if ($searchQuery) {
            $post = $messageRepository->searchByQuery($searchQuery);
        } else {
            $post = $messageRepository->findBy(
                ['type' => 'post'],
                ['createdAt' => 'DESC'],
                5
            );
        }



        return $this->render('home/index.html.twig', [
            'lastPost' => $post,
            'searchQuery' => $searchQuery,
        ]);
    }
}
