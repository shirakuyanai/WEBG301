<?php

namespace App\Controller;

use App\Repository\CartRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(Request $request,
                        ProductRepository $productRepository, 
                        CartRepository $cartRepository, 
                        CategoryRepository $categoryRepository): Response
    {
        return $this->render('/UserInterface/Homepage.html.twig', [ 
            'controller_name' => 'Landing Page',
            'products' => $productRepository->findAll(),
            'carts' => $cartRepository->findAll(),
            'categories' => $categoryRepository->findAll(),
        ]);
    }
}

// index/index.html.twig
