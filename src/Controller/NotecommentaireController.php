<?php

namespace App\Controller;

use App\Entity\Notecommentaire;
use App\Form\NotecommentaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/notecommentaire")
 */
class NotecommentaireController extends AbstractController
{
    /**
     * @Route("/", name="app_notecommentaire_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $notecommentaires = $entityManager
            ->getRepository(Notecommentaire::class)
            ->findAll();

        return $this->render('notecommentaire/index.html.twig', [
            'notecommentaires' => $notecommentaires,
        ]);
    }

    /**
     * @Route("/new", name="app_notecommentaire_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $notecommentaire = new Notecommentaire();
        $form = $this->createForm(NotecommentaireType::class, $notecommentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($notecommentaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_notecommentaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('notecommentaire/new.html.twig', [
            'notecommentaire' => $notecommentaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idnote}", name="app_notecommentaire_show", methods={"GET"})
     */
    public function show(Notecommentaire $notecommentaire): Response
    {
        return $this->render('notecommentaire/show.html.twig', [
            'notecommentaire' => $notecommentaire,
        ]);
    }

    /**
     * @Route("/{idnote}/edit", name="app_notecommentaire_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Notecommentaire $notecommentaire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NotecommentaireType::class, $notecommentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_notecommentaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('notecommentaire/edit.html.twig', [
            'notecommentaire' => $notecommentaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idnote}", name="app_notecommentaire_delete", methods={"POST"})
     */
    public function delete(Request $request, Notecommentaire $notecommentaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$notecommentaire->getIdnote(), $request->request->get('_token'))) {
            $entityManager->remove($notecommentaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_notecommentaire_index', [], Response::HTTP_SEE_OTHER);
    }
}
