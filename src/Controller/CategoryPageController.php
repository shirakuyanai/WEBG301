<?php

namespace App\Controller;

use App\Repository\CartRepository;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryPageController extends AbstractController
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
    #[Route('/productlist/{category_id}', name: 'app_category_page', methods : ['POST', 'GET'])]
    public function index($category_id): Response
    {
        return $this->render('/UserInterface/ProductByCategory.html.twig', [
            'products' => $this->productRepository->findByCategory($category_id),
            'carts' => $this->cartRepository->findAll(),
            'categories' => $this->categoryRepository->findAll(),
        ]);
    }
}
