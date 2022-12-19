<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemberPanelController extends AbstractController
{
    #[Route('/admin/member', name: 'app_member_panel')]
    public function index(): Response
    {
        return $this->render('Admin_interface/member_panel/index.html.twig', [
            'controller_name' => 'MemberPanelController',
        ]);
    }
}
