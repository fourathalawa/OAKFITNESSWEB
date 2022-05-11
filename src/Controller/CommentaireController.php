<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Notecommentaire;
use App\Form\Commentaire1Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commentaire")
 */
class CommentaireController extends AbstractController
{
    /*
    /**
     * @Route("/", name="app_commentaire_index", methods={"GET"})
     */
  /*  public function index(EntityManagerInterface $entityManager): Response
    {
        $commentaires = $entityManager
            ->getRepository(Commentaire::class)
            ->findAll();

        return $this->render('commentaire/index.html.twig', [
            'commentaires' => $commentaires,
         //   'nb' => $number =  $this->getDoctrine()->getRepository(Notecommentaire::class)->countlikes($id);
        ]);
    } */
    /**
     * @Route("/", name="app_commentaire_index", methods={"GET"})
     */
    public function afficher(EntityManagerInterface $entityManager): Response
    {
        $commentaires = $entityManager
            ->getRepository(Commentaire::class)
            ->findAll();

        $output = array();
        foreach($commentaires as $commentaire)
        {

            $em = $this->getDoctrine()->getManager();
            $qb = $em->createQueryBuilder();

            $result = $qb->select('COUNT(u)')
                ->from('App\Entity\Notecommentaire' , 'u')
                ->where('u.idcommentaire= :id')

                ->setParameter('id',$commentaire->getId())
                ->getQuery()
                ->getSingleScalarResult();
            $output[] = array($commentaire->getId(),$commentaire->getCommentaire(), $commentaire->getDatecommentaire(),$result);
        }
    //  $result = new JsonResponse($output);
        return $this->render('commentaire/index.html.twig', [
            'outputs' => $output,
           // 'commentaires' => $commentaires,
            //   'nb' => $number =  $this->getDoctrine()->getRepository(Notecommentaire::class)->countlikes($id);
        ]);
    }

    /**
     * @Route("/new", name="app_commentaire_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(Commentaire1Type::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_commentaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commentaire/new.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_commentaire_show", methods={"GET"})
     */
    public function show(Commentaire $commentaire): Response
    {
        return $this->render('commentaire/show.html.twig', [
            'commentaire' => $commentaire,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_commentaire_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Commentaire1Type::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $v = $commentaire->getIdpublication();
            return $this->redirectToRoute('app_publication_show', ['id' => $v], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commentaire/edit.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_commentaire_delete", methods={"POST"})
     */
    public function delete(Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commentaire->getId(), $request->request->get('_token'))) {
            $v = $commentaire->getIdpublication();
            $entityManager->remove($commentaire);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_publication_show', ['id' => $v], Response::HTTP_SEE_OTHER);

      //  return $this->redirectToRoute('app_publication_index', [], Response::HTTP_SEE_OTHER);
    }

    public function count( $id)
    {
        $number =  $this->getDoctrine()->getRepository(Notecommentaire::class)->countlikes($id);


    }
}
