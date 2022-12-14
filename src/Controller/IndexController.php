<?php

namespace App\Controller;

use App\Repository\CartRepository;
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
    public function __construct(ProductRepository $productRepository, CartRepository $cartRepository)
    {
        $this->productRepository = $productRepository;
        $this->cartRepository = $cartRepository;
    }
    #[Route('/', name: 'app_index')]
    public function index(Request $request): Response
    {
        return $this->render('UserInterface/Homepage.html.twig', [
            'controller_name' => 'Landing Page',
            'products' => $this->productRepository->findAll(),
            'carts' => $this->cartRepository->findAll(),
        ]);
    }

    #[Route('/category', name: 'app_category')]
    public function category(Request $request): Response
    {
        return $this->render('UserInterface/CategoryPage.html.twig', [
            'controller_name' => 'Landing Page',
            'products' => $this->productRepository->findAll(),
            'carts' => $this->cartRepository->findAll(),
        ]);
    }
}
