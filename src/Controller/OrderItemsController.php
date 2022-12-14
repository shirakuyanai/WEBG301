<?php

namespace App\Controller;

use App\Entity\OrderItems;
use App\Form\OrderItemsType;
use App\Repository\OrderItemsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/order/items')]
class OrderItemsController extends AbstractController
{
    #[Route('/', name: 'app_order_items_index', methods: ['GET'])]
    public function index(OrderItemsRepository $orderItemsRepository): Response
    {
        return $this->render('order_items/index.html.twig', [
            'order_items' => $orderItemsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_order_items_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OrderItemsRepository $orderItemsRepository): Response
    {
        $orderItem = new OrderItems();
        $form = $this->createForm(OrderItemsType::class, $orderItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $orderItemsRepository->save($orderItem, true);

            return $this->redirectToRoute('app_order_items_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('order_items/new.html.twig', [
            'order_item' => $orderItem,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_order_items_show', methods: ['GET'])]
    public function show(OrderItems $orderItem): Response
    {
        return $this->render('order_items/show.html.twig', [
            'order_item' => $orderItem,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_order_items_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, OrderItems $orderItem, OrderItemsRepository $orderItemsRepository): Response
    {
        $form = $this->createForm(OrderItemsType::class, $orderItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $orderItemsRepository->save($orderItem, true);

            return $this->redirectToRoute('app_order_items_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('order_items/edit.html.twig', [
            'order_item' => $orderItem,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_order_items_delete', methods: ['POST'])]
    public function delete(Request $request, OrderItems $orderItem, OrderItemsRepository $orderItemsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$orderItem->getId(), $request->request->get('_token'))) {
            $orderItemsRepository->remove($orderItem, true);
        }

        return $this->redirectToRoute('app_order_items_index', [], Response::HTTP_SEE_OTHER);
    }
}
