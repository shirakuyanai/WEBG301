<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsPanelController extends AbstractController
{
    #[Route('/admin/products', name: 'app_products_panel')]
    public function index(): Response
    {
        return $this->render('Admin_interface/products_panel/index.html.twig', [
            'controller_name' => 'ProductsPanelController',
        ]);
    }
}
