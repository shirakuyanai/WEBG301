<?php

namespace App\Controller;

use App\Repository\CartRepository;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoriesController extends AbstractController
{
    #[Route('/productlist/{category_id}', name: 'app_category_page', methods : ['POST', 'GET'])]
    public function index($category_id, ProductRepository $productRepository, CartRepository $cartRepository, CategoryRepository $categoryRepository): Response
    {
        return $this->render('/UserInterface/ProductByCategory.html.twig', [
            'products' => $productRepository->findByCategory($category_id),
            'carts' => $cartRepository->findAll(),
            'categories' => $categoryRepository->findAll(),
        ]);
    }
}
