<?php

namespace App\Controller;

use App\Entity\Salledesport;
use App\Form\SalledesportType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/salledesport")
 */
class SalledesportController extends AbstractController
{
    /**
     * @Route("/", name="app_salledesport_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $salledesports = $entityManager
            ->getRepository(Salledesport::class)
            ->findAll();

        return $this->render('salledesport/alladherent.html.twig', [
            'salledesports' => $salledesports,
        ]);
    }

    /**
     * @Route("/new", name="app_salledesport_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $salledesport = new Salledesport();
        $form = $this->createForm(SalledesportType::class, $salledesport);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager->persist($salledesport);
            $entityManager->flush();

            return $this->redirectToRoute('app_salledesport_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('salledesport/new.html.twig', [
            'salledesport' => $salledesport,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idSalle}", name="app_salledesport_show", methods={"GET"})
     */
    public function show(Salledesport $salledesport): Response
    {
        return $this->render('salledesport/show.html.twig', [
            'salledesport' => $salledesport,
        ]);
    }

    /**
     * @Route("/{idSalle}/edit", name="app_salledesport_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Salledesport $salledesport, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SalledesportType::class, $salledesport);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_salledesport_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('salledesport/edit.html.twig', [
            'salledesport' => $salledesport,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idSalle}", name="app_salledesport_delete", methods={"POST"})
     */
    public function delete(Request $request, Salledesport $salledesport, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$salledesport->getIdSalle(), $request->request->get('_token'))) {
            $entityManager->remove($salledesport);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_salledesport_index', [], Response::HTTP_SEE_OTHER);
    }
}
