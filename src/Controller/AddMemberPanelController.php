<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddMemberPanelController extends AbstractController
{
    #[Route('/admin/member/addpanel', name: 'app_add_member_panel')]
    public function index(): Response
    {
        return $this->render('Admin_interface\member_panel\add_member_panel\addmember.html.twig', [
            'controller_name' => 'AddMemberPanelController',
        ]);
    }
}
