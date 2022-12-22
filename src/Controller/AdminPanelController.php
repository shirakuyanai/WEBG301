<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\CartRepository;
use App\Repository\OrderDetailsRepository;
use App\Repository\OrderItemsRepository;
use App\Repository\UserRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AdminPanelController extends AbstractController
{
    private $userRepository;
    private $productRepository;
    private $cartRepository;
    private $orderRepository;
    private $orderItemsRepository;



    public function __construct(OrderItemsRepository $orderItemsRepository , OrderDetailsRepository $orderRepository , UserRepository $userRepository, ProductRepository $productRepository, CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
        $this->orderItemsRepository = $orderItemsRepository;
    }
    #[Route('/', name: 'app_admin_index')]
    public function index(): Response
    {
        $user = $this->getUser();
        if (!$user)
        {
            return $this->redirectToRoute('app_login');
        }
        $inventory = 0;
        $products = $this->productRepository->findAll();
        foreach($products as $product)
        {
            $inventory = $inventory + $product->getStock();
        }

        return $this->render('Admin_interface/admin_panel/index.html.twig', [
            'controller_name' => 'AdminPanelController',
            'total_sales' => count($this->orderRepository->findByStatus(3)),
            'total_members' => count($this->userRepository->findAll()),
            'inventory' => $inventory,
            'orders' => $this->orderRepository->findAll(),
            'order_items' => $this->orderItemsRepository->findAll(),
        ]);
    }

    // #[Route('/accounts', name: 'app_admin_panel')]
    // public function show_user(Request $request, UserRepository $userRepository): Response
    // {
    //     // $username = $request->request->getUser()->getUserIdentifier();
    //     // if (!$username)
    //     // {
    //     //     return $this->redirectToRoute('app_login');
    //     // }
    //     // $user_role = $userRepository->findOneByUsername($username)->getRoles();
        

    //     return $this->render('Admin_interface/admin_panel/index.html.twig', [
    //         'controller_name' => 'AdminPanelController',
    //         'users' => $this->userRepository->findAll(),
    //     ]);
    // }

    #[Route('/product', name: 'app_admin_product')]
    public function show_product(Request $request, UserRepository $userRepository): Response
    {
        // $username = $request->request->getUser()->getUserIdentifier();
        // if (!$username)
        // {
        //     return $this->redirectToRoute('app_login');
        // }
        // $user_role = $userRepository->findOneByUsername($username)->getRoles();
        

        return $this->render('Admin_interface/products_panel/index.html.twig', [
            'products' => $this->productRepository->findAll(),
        ]);
    }
}