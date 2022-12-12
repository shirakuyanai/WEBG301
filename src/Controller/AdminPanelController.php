<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPanelController extends AbstractController
{
    #[Route('/admin', name: 'app_admin_panel')]
    public function index(Request $request, UserRepository $userRepository): Response
    {
        // $username = $request->request->getUser()->getUserIdentifier();
        // if (!$username)
        // {
        //     return $this->redirectToRoute('app_login');
        // }
        // $user_role = $userRepository->findOneByUsername($username)->getRoles();
        

        return $this->render('Admin_interface/admin_panel/index.html.twig', [
            'controller_name' => 'AdminPanelController',
        ]);
    }
}
