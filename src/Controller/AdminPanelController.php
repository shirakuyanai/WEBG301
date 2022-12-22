<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\CartRepository;
use App\Repository\UserRepository;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
class AdminPanelController extends AbstractController
{
    private $userRepository;
    private $productRepository;
    
    private $cartRepository;
    private $categoryRepository;



    public function __construct(UserRepository $userRepository, ProductRepository $productRepository, CartRepository $cartRepository, CategoryRepository $categoryRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        
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
            'products' => $this->productRepository->findAll(),
            'categories' => $this->categoryRepository->findAll(),
            'users' => $this->userRepository->findAll(),
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