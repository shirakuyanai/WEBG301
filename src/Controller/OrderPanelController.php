<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderPanelController extends AbstractController
{
    #[Route('/admin/order', name: 'app_order_panel')]
    public function index(): Response
    {
        return $this->render('Admin_interface/order_panel/index.html.twig', [
            'controller_name' => 'OrderPanelController',
        ]);
    }
}
