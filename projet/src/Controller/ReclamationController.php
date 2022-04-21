<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Publication;
use App\Entity\Reclamation;
use App\Form\ReclamationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reclamation")
 */
class ReclamationController extends AbstractController
{
    /**
     * @Route("/", name="app_reclamation_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $reclamations = $entityManager
            ->getRepository(Reclamation::class)
            ->findAll();

        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamations,
        ]);
    }

    /**
     * @Route("/{id}/{idp}/new", name="app_reclamation_new", methods={"GET", "POST"})
     * @Entity("publication", expr="repository.find(idp)")
     */
    public function new(Request $request,Publication $publication,Commentaire $commentaire,EntityManagerInterface $entityManager): Response
    {


    $reclamation = new Reclamation();
     $form = $this->createForm(ReclamationType::class, $reclamation);
     $form->handleRequest($request);

     if ($form->isSubmitted() && $form->isValid()) {
         $time = date('d/m/Y');
         $traitement = "non traite";
         $reclamation->setPubrec($publication->getPublication());
         $reclamation->setCommentairerec($commentaire->getCommentaire());
         $reclamation->setIduserreclamation($commentaire->getIduser());
         $reclamation->setEtatreclamation($traitement);
         $reclamation->setDatereclam($time);
         $reclamation->setIdcommentreclam($commentaire->getId());
         $entityManager->persist($reclamation);
         $entityManager->flush();
         $v = $commentaire->getIdpublication();

         return $this->redirectToRoute('app_publication_show', ['id' => $v], Response::HTTP_SEE_OTHER);
     }

     return $this->render('reclamation/new.html.twig', [
         'reclamation' => $reclamation,
         'form' => $form->createView(),
     ]);

    }

    /**
     * @Route("/{idreclamation}", name="app_reclamation_show", methods={"GET"})
     */
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    /**
     * @Route("/{idreclamation}/{idCommentReclam}/edit", name="app_reclamation_edit", methods={"GET", "POST"})
     * @Entity("commentaire", expr="repository.find(idCommentReclam)")
     */
    public function edit(Request $request, Reclamation $reclamation,Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {
       /* $commentaire = $entityManager
            ->getRepository(Commentaire::class)
            ->find(idCommentReclam); */

        $entityManager->remove($commentaire);
        $entityManager->flush();

            $reclamation->setEtatreclamation("traite");
            $entityManager->flush();

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);


        return $this->render('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/{idreclamation}", name="app_reclamation_delete", methods={"POST"})
     */
    public function delete(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getIdreclamation(), $request->request->get('_token'))) {
            $entityManager->remove($reclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }
}
