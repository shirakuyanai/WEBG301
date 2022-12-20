<?php

namespace App\Controller;

use App\Entity\Product;

use App\Form\ProductType;
use App\Repository\CartRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function PHPUnit\Framework\throwException;

// #[Route('/admin')]
class ProductsPanelController extends AbstractController
{
    private $userRepository;
    private $productRepository;
    
    private $cartRepository;



    public function __construct(UserRepository $userRepository, ProductRepository $productRepository, CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        
    }
    #[Route('admin/product', name: 'app_products_panel')]
    public function index(): Response
    {
        return $this->render('Admin_interface/products_panel/index.html.twig', [
            'controller_name' => 'ProductsPanelController',
        ]);
    }
        
    #[Route('/product/{id}', name: 'app_product_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/product/{id}/delete', name: 'app_product_delete', methods: ['GET','POST'])]
    public function delete(Request $request, $id): Response
    {
        
        $product = $this->productRepository->find($id);
            $this->productRepository->remove($product, true);

        return $this->redirectToRoute('app_admin_product', [], Response::HTTP_SEE_OTHER);
    }

    

    #[Route('admin/product/new', name: 'app_product_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProductRepository $productRepository): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        $img = $product->getImage();
        $imgName = uniqid();
        $imgExtension = $img->guessExtension();
        $imageName = $imgName . "." . $imgExtension;
        try {
            $img->move(
               $this->getParameter('product_image'),
               $imageName
            );
        } catch (FileException $e) {
            throwException($e);
        }
        $product->setImage($imageName);
            
            $productRepository->save($product, true);
            return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/Admin_interface/products_panel/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }
    

    // #[Route('/product/{id}', name: 'app_product_show', methods: ['GET'])]
    // public function show(Product $product): Response
    // {
    //     return $this->render('product/show.html.twig', [
    //         'product' => $product,
    //     ]);
    // }

    #[Route('/product/{id}/edit', name: 'app_product_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productRepository->save($product, true);

            return $this->redirectToRoute('app_admin_product', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/Admin_interface/products_panel/edit_product.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }
}
