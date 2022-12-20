<?php

namespace App\Controller;

use App\Entity\OrderDetails;
use App\Entity\OrderItems;
use App\Entity\UserAddress;
use App\Form\OrderDetailsType;
use App\Repository\OrderDetailsRepository;
use App\Repository\OrderItemsRepository;
use App\Repository\CartRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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

    public function __construct(OrderDetailsRepository $orderDetailsRepository,
                                OrderItemsRepository $OrderItemsRepository,
                                UserRepository $userRepository,
                                ManagerRegistry $managerRegistry,
                                CartRepository $cartRepository,
                                ProductRepository $productRepository
                                )
    {
        $this->orderDetailsRepository = $orderDetailsRepository;
        $this->OrderItemsRepository = $OrderItemsRepository;
        $this->userRepository = $userRepository;
        $this->managerRegistry = $managerRegistry;
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
    }

    #[Route('/', name: 'app_order')]
    public function index(): Response
    {
        $user = $this->getUser();
        if (!$user)
        {
            return new Response('An error has occurred, please refresh try again later.', 201, [
                'content-type' => 'text/html'
            ]);
        }
        if (!$this->cartRepository->findByUser($user))
        {
            return $this->redirectToRoute('app_cart_index');
        }
        return $this->render('order/index.html.twig', [
            'carts' => $this->cartRepository->findByUser($user),
            'products' => $this->productRepository->findAll(),
        ]);
    }

    #[Route('/submit', name: 'app_submit_order', methods: ['GET', 'POST'])]
    public function submit(Request $request): Response
    {
        $user = $this->getUser();
        $this_user = $this->userRepository->find($user);
        if (!$user)
        {
            return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
        }

        $cart_items = $this->cartRepository->findByUser($user);

        if (count($cart_items) <= 0)
        {
            return $this->redirectToRoute('app_cart_index', [], Response::HTTP_SEE_OTHER);
        }

        $total = 0;

        $order_detail = new OrderDetails();

        $firstname = $request->request->get('firstname');
        $lastname = $request->request->get('lastname');
        $phone = $request->request->get('phone');
        $email = $request->request->get('email');
        $address_1 = $request->request->get('address_1');
        $address_2 = $request->request->get('address_2');
        $address_3 = $request->request->get('address_3');
        $address_4 = $request->request->get('address_4');
        $zipcode = $request->request->get('zipcode');
        $save_default_address = $request->request->get('save_default_address');

        // return new Response($save_address, 200, [
        //     'content-type' => 'text/html',
        // ]);
        
        $order_detail->setFirstname($firstname);
        $order_detail->setLastname($lastname);
        $order_detail->setPhone($phone);
        $order_detail->setEmail($email);
        $order_detail->setAddress1($address_1);
        $order_detail->setAddress2($address_2);
        $order_detail->setAddress3($address_3);
        $order_detail->setAddress4($address_4);
        $order_detail->setZipcode($zipcode);

        if ($save_default_address)
        {
            $this_user->setFirstname($firstname);
            $this_user->setLastname($lastname);
            $this_user->setPhone($phone);
            $this_user->setEmail($email);
            $this_user->setAddress1($address_1);
            $this_user->setAddress2($address_2);
            $this_user->setAddress3($address_3);
            $this_user->setAddress4($address_4);
            $this_user->setZipcode($zipcode);
        }

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
            
            $total = $total + $product->getPrice();
            $order_detail->setTotal($total);

            $product->setStock($product->getStock() - $quantity);

            $manager = $this->managerRegistry->getManager();
            $manager->persist($order_detail);
            $manager->persist($this_user);
            $manager->persist($order_item);
            $manager->flush();
            $this->cartRepository->remove($cart_item, true);
        }

        // return new Response('Order submitted successfully!', 200, 
        // ['content-type' => 'text/html']);

        return $this->render('/order/summary.html.twig', [
            'order_detail' => $order_detail,
            'order_items' => $order_item,
            'products' => $this->productRepository->findAll(),
        ]);
    }

    #[Route('/myorders', name: 'app_order_list')]
    public function orderList(): Response
    {
        $user = $this->getUser();
        if (!$user)
        {
            return new Response('An error has occurred, please refresh try again later.', 201, [
                'content-type' => 'text/html'
            ]);
        }
        return $this->render('order/orderlist.html.twig', [
            'order_details' => $this->orderDetailsRepository->findByUser($user),
            'order_items' => $this->OrderItemsRepository->findAll(),
        ]);
    }
}
