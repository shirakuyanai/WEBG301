<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CartRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{

  private $productRepository;
  private $categoryRepository;
  private $cartRepository;

  public function __construct(CartRepository $cartRepository, ProductRepository $productRepository, CategoryRepository $categoryRepository)
  {
    $this->productRepository = $productRepository;
    $this->categoryRepository = $categoryRepository;
    $this->cartRepository = $cartRepository;
  }



  #[Route('/search/asc', name: 'sort_price_ascending')]
  public function sortPriceAscending()
  {
    $user = $this->getUser();
    if (!$user)
    {
      $cart_count = 0;
    }
    $cart_count = count($this->cartRepository->findByUser($user));
    $products = $this->productRepository->sortProductPriceAsc();
    return $this->render(
      'search/index.html.twig',
      [
        'products' => $products,
        'cart_count' => $cart_count,
        'categories' => $this->categoryRepository->findAll(),
      ]
    );
  }


  #[Route('/search/desc', name: 'sort_price_descending')]
  public function sortPriceDescending()
  {
    $products = $this->productRepository->sortProductPriceDesc();
    $user = $this->getUser();
    if (!$user)
    {
      $cart_count = 0;
    }
    $cart_count = count($this->cartRepository->findByUser($user));
    return $this->render(
      'search/index.html.twig',
      [
        'products' => $products,
        'cart_count' => $cart_count,
        'categories' => $this->categoryRepository->findAll(),
      ]
    );
  }
  #[Route('/search', name: 'search_product', methods: ['POST', 'GET'])]
  public function searchProduct(Request $request)
  {
    $products = $this->productRepository->searchProduct($request->get('keyword'));
    $session = $request->getSession();
    $session->set('search', true);
    $user = $this->getUser();
    if (!$user)
    {
      $cart_count = 0;
    }
    $cart_count = count($this->cartRepository->findByUser($user));
    return $this->render(
      '\search\index.html.twig',
      [
        'products' => $products,
        'cart_count' => $cart_count,
        'categories' => $this->categoryRepository->findAll(),
      ]
    );
  }
}
