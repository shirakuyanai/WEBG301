<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    private $categoryRepository;
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    #[Route('admin/category', name: 'app_category_index', methods: ['GET'])]
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('/Admin_interface/category_panel/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('admin/category/new', name: 'app_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CategoryRepository $categoryRepository): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->save($category, true);

            return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Admin_interface\category_panel\new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    // #[Route('/{id}', name: 'app_category_show', methods: ['GET'])]
    // public function show($id): Response
    // {
    //     $category = $this->categoryRepository->find($id);
    //     return $this->render('category/show.html.twig', [
    //         'category' => $category,
    //     ]);
    // }

    #[Route('admin/category/{id}/edit', name: 'app_category_detail', methods: ['GET', 'POST'])]
    public function detail($id): Response
    {
        return $this->render('Admin_interface\category_panel\show.html.twig', [
            'category' => $this->categoryRepository->find($id),
        ]);
    }

    #[Route('category/{id}/delete', name: 'app_category_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        $categoryRepository->remove($category, true);

        return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('admin/category/{id}/edit', name: 'app_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->save($category, true);

            return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Admin_interface\category_panel\edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

  
}
