<?php

namespace App\Controller\admin;

use App\Form\MessageFormType;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Paginator;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminController extends AbstractController
{

    #[Route('/admin/list', name: 'app_admin_list')]
    public function index(MessageRepository $messageRepository, Request $request, PaginatorInterface $paginator): Response
    {

        $posts = $paginator->paginate(
            $messageRepository->getAll(), /* query NOT result */
            $request->query->getInt('page', 1), /* page number */
            10 /* limit per page */
        );

        return $this->render('admin/admin_list.html.twig', [
            'posts' => $posts
        ]);
    }

    #[Route('/admin/view/{id}', name: 'app_admin_view')]
    public function viewGame($id, MessageRepository $messageRepository): Response
    {

        $post = $messageRepository->find($id);

        return $this->render('admin/admin_view.html.twig', [
            'post' => $post
        ]);
    }

    #[Route('/admin/delete/{id}', name: 'app_admin_delete')]
    public function deleteGame($id, MessageRepository $messageRepository, EntityManagerInterface $entityManager): Response
    {

        $message = $messageRepository->find($id);
        $entityManager->remove($message);
        $entityManager->flush();

        return $this ->redirectToRoute('app_admin_list');
    }

    #[Route('/admin/edit/{id}', name: 'app_admin_edit')]
    public function editGame($id, MessageRepository $messageRepository, Request $request, EntityManagerInterface $entityManager): Response
    {

        $message = $messageRepository->find($id);
        $newMessageForm = $this->createForm(MessageFormType::class, $message);
        $newMessageForm->handleRequest($request);

        if($newMessageForm->isSubmitted()&& $newMessageForm->isValid()) {
            $entityManager->persist($message);
            $entityManager->flush();
            return $this->redirectToRoute('app_admin_list');
        }

        return $this->render('admin/admin_edit.html.twig', [
            'newMessageForm' => $newMessageForm
        ]);
    }

}
