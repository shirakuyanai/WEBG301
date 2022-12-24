<?php

namespace App\Controller;

use App\Entity\OrangeChef;
use App\Form\OrangeChefType;
use App\Repository\OrangeChefRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/orange/chef')]
class OrangeChefController extends AbstractController
{
    #[Route('/', name: 'app_orange_chef_index', methods: ['GET'])]
    public function index(OrangeChefRepository $orangeChefRepository): Response
    {
        return $this->render('orange_chef/index.html.twig', [
            'orange_chefs' => $orangeChefRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_orange_chef_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OrangeChefRepository $orangeChefRepository): Response
    {
        $orangeChef = new OrangeChef();
        $form = $this->createForm(OrangeChefType::class, $orangeChef);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $orangeChefRepository->save($orangeChef, true);

            return $this->redirectToRoute('app_orange_chef_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('orange_chef/new.html.twig', [
            'orange_chef' => $orangeChef,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_orange_chef_show', methods: ['GET'])]
    public function show(OrangeChef $orangeChef): Response
    {
        return $this->render('orange_chef/show.html.twig', [
            'orange_chef' => $orangeChef,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_orange_chef_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, OrangeChef $orangeChef, OrangeChefRepository $orangeChefRepository): Response
    {
        $form = $this->createForm(OrangeChefType::class, $orangeChef);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $orangeChefRepository->save($orangeChef, true);

            return $this->redirectToRoute('app_orange_chef_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('orange_chef/edit.html.twig', [
            'orange_chef' => $orangeChef,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_orange_chef_delete', methods: ['POST'])]
    public function delete(Request $request, OrangeChef $orangeChef, OrangeChefRepository $orangeChefRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$orangeChef->getId(), $request->request->get('_token'))) {
            $orangeChefRepository->remove($orangeChef, true);
        }

        return $this->redirectToRoute('app_orange_chef_index', [], Response::HTTP_SEE_OTHER);
    }
}
