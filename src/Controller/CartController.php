<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Form\CartType;
use App\Repository\CartRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart')]
class CartController extends AbstractController
{

    private $cartRepository;
    private $productRepository;
    private $userRepository;
    private $managerRegistry;


    public function __construct(CartRepository $cartRepository, ProductRepository $productRepository, UserRepository $userRepository, ManagerRegistry $managerRegistry)
    {
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
        $this->managerRegistry = $managerRegistry;
    }

    #[Route('/', name: 'app_cart_index', methods: ['GET'])]
    public function index(): Response
    {
        $username = $this->getUser()->getUserIdentifier();
        $user = $this->userRepository->findOneByUsername($username);
        return $this->render('cart/index.html.twig', [
            'carts' => $this->cartRepository->findByUser($user->getId()),
            'products' => $this->productRepository->findAll(),
        ]);
    }

    #[Route('/add_to_cart/{product_id}/{username}/{quantity}', name: 'app_product_add_to_cart', methods: ['GET', 'POST'])]
    public function addCart(Request $request, $product_id, $username, $quantity): Response
    {
        if ($this->productRepository->findOneById($product_id)->getStock() == 0)
        {
            return new Response("Item out of stock! Please select another one.", Response::HTTP_BAD_REQUEST,
            ['content-type' => 'text/html']);
        }

        $user = $this->userRepository->findOneByUsername($username);
        $cart = $this->cartRepository->findOneBySomeField($product_id, $user->getId());
        $product = $this->productRepository->findOneById($product_id);
        if (!$cart)
        {
            $cart = new Cart();
            $cart->setUser($user);
            $cart->setProduct($product);
        }

        $cart->setQuantity($cart->getQuantity() + $quantity);
        $product->setStock($product->getStock() - $quantity);

        $manager = $this->managerRegistry->getManager();
        $manager->persist($cart);
        $manager->persist($product);
        $manager->flush();

        return new Response("Blog added successfully!", Response::HTTP_CREATED, // 201
        ['content-type' => 'text/html']);
    }

    #[Route('/new', name: 'app_cart_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CartRepository $cartRepository): Response
    {
        $cart = new Cart();
        $form = $this->createForm(CartType::class, $cart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cartRepository->save($cart, true);

            return $this->redirectToRoute('app_cart_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cart/new.html.twig', [
            'cart' => $cart,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cart_show', methods: ['GET'])]
    public function show(Cart $cart): Response
    {
        return $this->render('cart/show.html.twig', [
            'cart' => $cart,
        ]);
    }

    #[Route('/edit', name: 'app_cart_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request): Response
    {
        $id = $request->request->get('cart_id');
        $cart = $this->cartRepository->find($id);

        if (!$cart)
        {
            // return new Response("Item does not exist anymore.", Response::HTTP_BAD_REQUEST,
            // ['content-type' => 'text/html']);
            return $this->redirectToRoute('app_cart_index', [], Response::HTTP_SEE_OTHER);
        }
        
        $new_quantity = $request->request->get('input_quantity');
        $old_quantity = $cart->getQuantity();
        $cart->setQuantity($new_quantity);
        
        $product = $this->productRepository->find($cart->getProduct());
        $product->setStock($product->getStock() + $old_quantity - $new_quantity);
        $manager = $this->managerRegistry->getManager();
        $manager->persist($product);
        $manager->persist($cart);
        $manager->flush();

        return $this->redirectToRoute('app_cart_index', [], Response::HTTP_SEE_OTHER);

        // return new Response($new_quantity, 200,
        //     ['content-type' => 'text/html']);
    }

    #[Route('/{id}', name: 'app_cart_delete', methods: ['POST'])]
    public function delete($id): Response
    {
        $cart = $this->cartRepository->find($id);

        if (!$cart)
        {
            return new Response("Item does not exist.", Response::HTTP_BAD_REQUEST,
            ['content-type' => 'text/html']);
        }
        $product = $this->productRepository->find($cart->getProduct());
        $product->setStock($product->getStock() + $cart->getQuantity());
        $manager = $this->managerRegistry->getManager();
        $manager->persist($product);
        $manager->flush();
        $this->cartRepository->remove($cart, true);

        return $this->redirectToRoute('app_cart_index', [], Response::HTTP_SEE_OTHER);
    }
}
