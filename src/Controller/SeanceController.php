<?php

namespace App\Controller;

use DateTime;
use App\Entity\Salle;
use App\Entity\Seance;
use DateTimeImmutable;
use App\Form\SeanceType;
use App\Repository\SalleRepository;
use App\Repository\SeanceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/seance')]
class SeanceController extends AbstractController
{
    #[Route('/', name: 'seance_index', methods: ['GET'])]
    public function index(SeanceRepository $seanceRepository): Response
    {
        return $this->render('seance/index.html.twig', [
            'seances' => $seanceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'seance_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $seance = new Seance();
        $form = $this->createForm(SeanceType::class, $seance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $seance->setupdateAt(new DateTime());
            $seance->setcreatedAt(new DateTimeImmutable());
            $entityManager->persist($seance);
            $entityManager->flush();

            return $this->redirectToRoute('seance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('seance/new.html.twig', [
            'seance' => $seance,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'seance_show', methods: ['GET'])]
    public function show(Seance $seance): Response
    {
        return $this->render('seance/show.html.twig', [
            'seance' => $seance,
        ]);
    }

    #[Route('/{id}/edit', name: 'seance_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Seance $seance, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SeanceType::class, $seance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $seance->setupdateAt(new DateTime());
            $entityManager->persist($seance);
            $entityManager->flush();

            return $this->redirectToRoute('seance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('seance/edit.html.twig', [
            'seance' => $seance,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'seance_delete', methods: ['POST'])]
    public function delete(Request $request, Seance $seance, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$seance->getId(), $request->request->get('_token'))) {
            $entityManager->remove($seance);
            $entityManager->flush();
        }

        return $this->redirectToRoute('seance_index', [], Response::HTTP_SEE_OTHER);
    }

}
