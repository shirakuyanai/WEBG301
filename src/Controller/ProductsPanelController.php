<?php

namespace App\Controller;

use App\Entity\Product;

use App\Form\ProductType;
use App\Repository\CartRepository;
use App\Repository\UserRepository;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use function PHPUnit\Framework\throwException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

// #[Route('/admin')]
class ProductsPanelController extends AbstractController
{
    private $userRepository;
    private $productRepository;
    private $cartRepository;
    private $categoryRepository;


    public function __construct(UserRepository $userRepository, ProductRepository $productRepository, CartRepository $cartRepository, CategoryRepository $categoryRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->cartRepository = $cartRepository;
        $this->categoryRepository = $categoryRepository;
    }
    #[Route('admin/product', name: 'app_products_panel')]
    public function index(): Response
    {
        return $this->render('Admin_interface/products_panel/index.html.twig', [
            'controller_name' => 'ProductsPanelController',
        ]);
    }


    

    #[Route('admin/product/new', name: 'app_product_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
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
            
            $this->productRepository->save($product, true);
            return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/Admin_interface/products_panel/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/product/{id}', name: 'app_product_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        $user = $this->getUser();
        if (!$user)
        {
            $cart_count = 0;
        }
        $cart_count = count($this->cartRepository->findByUser($user));

        return $this->render('product/show.html.twig', [
            'product' => $product,
            'cart_count' => $cart_count,
            'categories' => $this->categoryRepository->findAll(),
        ]);
    }

    #[Route('/admin/product/{id}', name: 'app_product_show_admin', methods: ['GET'])]
    public function detail($id): Response
    {
        $product = $this->productRepository->find($id);
        return $this->render('/Admin_interface/products_panel/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/admin/product/{id}/edit', name: 'app_product_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request,$id, ProductRepository $productRepository): Response
    {
        $product = $this->productRepository->find($id);
        $old_img = $product->getImage();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $imageFile = $form['image']->getData();
            if ($imageFile)
            {
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
            }
            
                
            $productRepository->save($product, true);
            return $this->redirectToRoute('app_product_edit', array('id' => $product), Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/Admin_interface/products_panel/edit_product.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }


    #[Route('/admin/product/{id}/delete', name: 'app_product_delete', methods: ['GET','POST'])]
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token')))
        {
            $this->productRepository->remove($product, true);
        }
            

        return $this->redirectToRoute('app_admin_product', [], Response::HTTP_SEE_OTHER);
    }
}