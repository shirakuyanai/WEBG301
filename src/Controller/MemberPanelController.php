<?php

namespace App\Controller;

use App\Form\UserType;
use App\Entity\User;
use App\Repository\CartRepository;
use App\Repository\OrderDetailsRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemberPanelController extends AbstractController
{
    private $userRepository;
    private $cartRepository;
    private $orderDetailsRepository;

    public function __construct(UserRepository $userRepository, CartRepository $cartRepository, OrderDetailsRepository $orderDetailsRepository){
        $this->userRepository = $userRepository;
        $this->cartRepository = $cartRepository;
        $this->orderDetailsRepository = $orderDetailsRepository;
    }

    #[Route('/admin/member', name: 'app_member_panel')]
    public function index(): Response
    {
        return $this->render('Admin_interface/member_panel/index.html.twig', [
            'users' => $this->userRepository->findAll(),
        ]);
    }
    #[Route('/admin/member/{id}/show', name: 'app_member_show')]
    public function show(User $user): Response
    {
        return $this->render('Admin_interface/member_panel/show.html.twig', [
            'user' => $user,
        ]);
    }
    // #[Route('admin/member/new', name: 'app_member_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, UserRepository $userRepository): Response
    // {
    //     $user = new User();
    //     $form = $this->createForm(Type::class, $user);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $userRepository->save($user, true);

    //         return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('/Admin_interface/member_panel/new.html.twig', [
    //         'user' => $user,
    //         'form' => $form,
    //     ]);
    // }
    
    #[Route('admin/member/{id}/edit', name: 'app_member_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userRepository->save($user, true);

            return $this->redirectToRoute('app_member_panel', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/Admin_interface/member_panel/edit_member.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}