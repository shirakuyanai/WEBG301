<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditMemberPanelController extends AbstractController
{
    #[Route('/edit/member/panel', name: 'app_edit_member_panel')]
    public function index(): Response
    {
        return $this->render('edit_member_panel/index.html.twig', [
            'controller_name' => 'EditMemberPanelController',
        ]);
    }
}
