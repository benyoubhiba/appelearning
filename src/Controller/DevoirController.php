<?php

namespace App\Controller;

use App\Entity\Devoir;
use App\Form\DevoirType;
use App\Repository\DevoirRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/devoir')]
class DevoirController extends AbstractController
{
    #[Route('/', name: 'app_devoir_index', methods: ['GET'])]
    public function index(DevoirRepository $devoirRepository): Response
    {
        return $this->render('devoir/index.html.twig', [
            'devoirs' => $devoirRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_devoir_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DevoirRepository $devoirRepository): Response
    {
        $devoir = new Devoir();
        $form = $this->createForm(DevoirType::class, $devoir);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $devoirRepository->add($devoir);
            return $this->redirectToRoute('app_devoir_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('devoir/new.html.twig', [
            'devoir' => $devoir,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_devoir_show', methods: ['GET'])]
    public function show(Devoir $devoir): Response
    {
        return $this->render('devoir/show.html.twig', [
            'devoir' => $devoir,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_devoir_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Devoir $devoir, DevoirRepository $devoirRepository): Response
    {
        $form = $this->createForm(DevoirType::class, $devoir);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $devoirRepository->add($devoir);
            return $this->redirectToRoute('app_devoir_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('devoir/edit.html.twig', [
            'devoir' => $devoir,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_devoir_delete', methods: ['POST'])]
    public function delete(Request $request, Devoir $devoir, DevoirRepository $devoirRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$devoir->getId(), $request->request->get('_token'))) {
            $devoirRepository->remove($devoir);
        }

        return $this->redirectToRoute('app_devoir_index', [], Response::HTTP_SEE_OTHER);
    }
}
