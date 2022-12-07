<?php

namespace App\Controller;

use App\Repository\CartRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class IndexController extends AbstractController
{
    private $productRepository;
    private $userRepository;
    private $authenticationUtils;
    private $cartRepository;
    public function __construct(CartRepository $cartRepository, ProductRepository $productRepository, UserRepository $userRepository, AuthenticationUtils $authenticationUtils)
    {
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
        $this->authenticationUtils = $authenticationUtils;
        $this->cartRepository = $cartRepository;
    }

    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        $username = $this->authenticationUtils->getLastUsername();
        $user_id = $this->userRepository->findOneByUsername($username);
        $cart_count = count($this->cartRepository->findByUser($user_id));

        return $this->render('index/index.html.twig', [
            'controller_name' => 'Landing Page',
            'products' => $this->productRepository->findAll(),
            'user_id' => $user_id,
            'cart_count' => $cart_count,
        ]);
    }
    #[Route('/cart', name: 'app_cart')]
    public function displayCartItems(): Response
    {
        $username = $this->authenticationUtils->getLastUsername();
        if (!$username)
        {
            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }
        
        $user_id = $this->userRepository->findOneByUsername($username);

        return $this->render('index/cart/cart.html.twig', [
            'controller_name' => 'Landing Page',
            'cart_items' => $this->cartRepository->findByUser($user_id),
            'products' => $this->productRepository->findAll(),
        ]);
    }
    
}
