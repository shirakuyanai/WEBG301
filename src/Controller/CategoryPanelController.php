<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryPanelController extends AbstractController
{
    #[Route('/admin/category', name: 'app_category_panel')]
    public function index(): Response
    {
        return $this->render('Admin_interface/category_panel/index.html.twig', [
            'controller_name' => 'CategoryPanelController',
        ]);
    }
}
