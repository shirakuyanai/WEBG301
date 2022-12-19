<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\CartRepository;
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



    public function __construct(UserRepository $userRepository, ProductRepository $productRepository, CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        
    }
    #[Route('/', name: 'app_admin_index')]
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