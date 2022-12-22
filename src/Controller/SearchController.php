<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{


  #[Route('/search/asc', name: 'sort_price_ascending')]
  public function sortPriceAscending(ProductRepository $productRepository, CategoryRepository $categoryRepository)
  {
    $products = $productRepository->sortProductPriceAsc();
    return $this->render(
      'search/index.html.twig',
      [
        'products' => $products,
        'categories' => $categoryRepository->findAll(),
      ]
    );
  }


  #[Route('/search/desc', name: 'sort_price_descending')]
  public function sortPriceDescending(ProductRepository $productRepository, CategoryRepository $categoryRepository)
  {
    $products = $productRepository->sortProductPriceDesc();
    return $this->render(
      'search/index.html.twig',
      [
        'products' => $products,
        'categories' => $categoryRepository->findAll(),
      ]
    );
  }
  #[Route('/search', name: 'search_product', methods: ['POST', 'GET'])]
  public function searchProduct(ProductRepository $productRepository, Request $request, CategoryRepository $categoryRepository)
  {
    $products = $productRepository->searchProduct($request->get('keyword'));
    $session = $request->getSession();
    $session->set('search', true);
    return $this->render(
      '\search\index.html.twig',
      [
        'products' => $products,
        'categories' => $categoryRepository->findAll(),
      ]
    );
  }
}
