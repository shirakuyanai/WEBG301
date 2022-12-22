<?php

namespace App\Controller;

use App\Entity\OrderDetails;
use App\Entity\OrderItems;
use App\Repository\OrderDetailsRepository;
use App\Repository\OrderItemsRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderPanelController extends AbstractController
{
    private $orderDetailRepository;
    private $orderItemsRepository;
    private $productRepository;

    public function __construct(OrderDetailsRepository $orderDetailRepository, OrderItemsRepository $orderItemsRepository, ProductRepository $productRepository)
    {
        $this->orderDetailRepository = $orderDetailRepository;
        $this->orderItemsRepository = $orderItemsRepository;
        $this->productRepository = $productRepository;
    }

    #[Route('/admin/order', name: 'app_order_panel')]
    public function index(): Response
    {
        return $this->render('Admin_interface/order_panel/index.html.twig', [
            'controller_name' => 'OrderPanelController',
            'order_details' => $this->orderDetailRepository->findAll(),
            'order_items' => $this->orderItemsRepository->findAll(),
        ]);
    }

    #[Route('/admin/order/{id}', name: 'app_order_detail')]
    public function show(OrderDetails $orderdetail): Response
    {
        return $this->render('Admin_interface/order_panel/show.html.twig', [
            'controller_name' => 'OrderPanelController',
            'order_detail' => $orderdetail,
            'order_items' => $this->orderItemsRepository->findByOrder($orderdetail),
            'products' => $this->productRepository->findAll(),
        ]);
    }
}
