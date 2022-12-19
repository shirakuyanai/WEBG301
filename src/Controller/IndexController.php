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
    private $productRepository;
    private $cartRepository;
    private $categoryRepository;
    public function __construct(ProductRepository $productRepository, CartRepository $cartRepository, CategoryRepository $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->cartRepository = $cartRepository;
        $this->categoryRepository = $categoryRepository;
    }
    #[Route('/', name: 'app_index')]
    public function index(Request $request): Response
    {
        return $this->render('/UserInterface/Homepage.html.twig', [ 
            'controller_name' => 'Landing Page',
            'products' => $this->productRepository->findAll(),
            'carts' => $this->cartRepository->findAll(),
            'categories' => $this->categoryRepository->findAll(),
        ]);
    }
}

// index/index.html.twig
