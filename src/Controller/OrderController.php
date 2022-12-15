<?php

namespace App\Controller;

use App\Entity\OrderDetails;
use App\Entity\OrderItems;
use App\Form\OrderDetailsType;
use App\Repository\OrderDetailsRepository;
use App\Repository\OrderItemsRepository;
use App\Repository\CartRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/order')]
class OrderController extends AbstractController
{
    private $orderDetailsRepository;
    private $OrderItemsRepository;
    private $userRepository;
    private $cartRepository;
    private $productRepository;
    private $managerRegistry;

    public function __construct(OrderDetailsRepository $orderDetailsRepository, OrderItemsRepository $OrderItemsRepository, UserRepository $userRepository, ManagerRegistry $managerRegistry, CartRepository $cartRepository, ProductRepository $productRepository)
    {
        $this->orderDetailsRepository = $orderDetailsRepository;
        $this->OrderItemsRepository = $OrderItemsRepository;
        $this->userRepository = $userRepository;
        $this->managerRegistry = $managerRegistry;
        $this->cartRepository = $cartRepository;
    }

    #[Route('/', name: 'app_order')]
    public function index(): Response
    {
        return $this->render('order/index.html.twig', [
            'controller_name' => 'OrderController',
        ]);
    }

    #[Route('/submit', name: 'app_submit_order')]
    public function create(): Response
    {
        $user = $this->getUser();
        if (!$user)
        {
            return $this->redirectToRoute('app_cart_index', [], Response::HTTP_SEE_OTHER);
        }

        $total = 0;
        $cart_items = $this->cartRepository->findByUser($user);

        $order_detail = new OrderDetails();
        $order_detail->setUser($user);
        $order_detail->setStatus(0);
        // 0: Unfinished
        // 1: Finished
        // 2: Cancelled
        $order_detail->setCreatedAt(\DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s")));

        

        foreach($cart_items as $cart_item){
            
            $product = $cart_item->getProduct();
            $order_item = new OrderItems();
            $order_item->setOrder($order_detail);
            $order_item->setProduct($product);
            $quantity = $cart_item->getQuantity();
            $order_item->setQuantity($quantity);
            $order_item->setCreatedAt(\DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s")));
            
            $total = $total + $product->getPrice();
            $order_detail->setTotal($total);

            $product->setStock($product->getStock() - $quantity);

            $manager = $this->managerRegistry->getManager();
            $manager->persist($order_item);
            $manager->persist($order_detail);
            $manager->flush();

            $this->cartRepository->remove($cart_item, true);
        }

        
        return new Response("Order submited successfully!", 200, [
            'content-type' => 'text/html',
        ]);
    }
}
