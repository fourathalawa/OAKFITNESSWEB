<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Transformation;
use App\Form\TransformationType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/transformation")
 */
class TransformationController extends AbstractController
{
    /**
     * @Route("/", name="app_transformation_index", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $donnes = $this->getDoctrine()
            ->getRepository(Transformation::class)
            ->findAll();
        $transformations= $paginator->paginate(
            $donnes, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3 // Nombre de résultats par page
        );

        return $this->render('transformation/index.html.twig', [
            'transformations' => $transformations,
        ]);
    }
    /**
     * @Route("/back", name="app_transformation_indexback", methods={"GET"})
     */
    public function backi(EntityManagerInterface $entityManager): Response
    {
        $transformations = $entityManager
            ->getRepository(Transformation::class)
            ->findAll();

        return $this->render('transformation/index_back.html.twig', [
            'transformations' => $transformations,
        ]);
    }

    /**
     * @Route("/new", name="app_transformation_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $transformation = new Transformation();
        $form = $this->createForm(TransformationType::class, $transformation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file1 = $transformation->getImageavant();
            $file2= $transformation->getImageapres();
            $fileName1 = md5(uniqid()).'.'.$file1->guessExtension();
            $fileName2 = md5(uniqid()).'.'.$file2->guessExtension();
            try {
                $file1->move(
                    $this->getParameter('brochures_directory'),
                    $fileName1

                );}catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
                try {
                    $file2->move(
                        $this->getParameter('brochures_directory'),
                        $fileName2

                    );
            } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
            $entityManager = $this->getDoctrine()->getManager();
            $transformation->setImageavant($fileName1);
            $transformation->setImageapres($fileName2);
            $entityManager->persist($transformation);
            $entityManager->flush();

            return $this->redirectToRoute('app_transformation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('transformation/new.html.twig', [
            'transformation' => $transformation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idimage}", name="app_transformation_show", methods={"GET"})
     */
    public function show(Transformation $transformation): Response
    {
        return $this->render('transformation/show.html.twig', [
            'transformation' => $transformation,
        ]);
    }

    /**
     * @Route("/back/{idimage}", name="app_transformation_backshow", methods={"GET"})
     */
    public function backS(Transformation $transformation): Response
    {
        return $this->render('transformation/backshow.html.twig', [
            'transformation' => $transformation,
        ]);
    }

    /**
     * @Route("/{idimage}/edit", name="app_transformation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Transformation $transformation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TransformationType::class, $transformation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file1 = $transformation->getImageavant();
            $file2= $transformation->getImageapres();
            $fileName1 = md5(uniqid()).'.'.$file1->guessExtension();
            $fileName2 = md5(uniqid()).'.'.$file2->guessExtension();
            try {
                $file1->move(
                    $this->getParameter('brochures_directory'),
                    $fileName1

                );}catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            try {
                $file2->move(
                    $this->getParameter('brochures_directory'),
                    $fileName2

                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $entityManager = $this->getDoctrine()->getManager();
            $transformation->setImageavant($fileName1);
            $transformation->setImageapres($fileName2);
            $entityManager->flush();

            return $this->redirectToRoute('app_transformation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('transformation/edit.html.twig', [
            'transformation' => $transformation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idimage}", name="app_transformation_delete", methods={"POST"})
     */
    public function delete(Request $request, Transformation $transformation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$transformation->getIdimage(), $request->request->get('_token'))) {
            $entityManager->remove($transformation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_transformation_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/back/{idimage}", name="app_transformation_deleteback", methods={"POST"})
     */
    public function backD(Request $request, Transformation $transformation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$transformation->getIdimage(), $request->request->get('_token'))) {
            $entityManager->remove($transformation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_transformation_indexback', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/voirTransformation", name="voirTransformation")
     */
    public function voirTransformation(): Response
    {
        $transformations = $this->getDoctrine()->getRepository(Transformation::class)->findAll();

        return $this->render('transformation/voir.html.twig',[
            'transformations' => $transformations
        ]);
    }
 //
    /**
     * @Route("/{idimage}/vote", name="app_transformation_upvote" )
     */
    public function vote(Request $request, EntityManagerInterface $em ): Response
    {
        $idI = $request->get('idimage');
        $transformation = $this->getDoctrine()->getRepository(Transformation::class)->findOneBy(array('idimage' => $idI)) ;
        if( $transformation)
        {   $nbrlikeavant = $transformation->getTlike();
            $nbrlike = $nbrlikeavant + 1 ;
            $transformation->setTlike($nbrlike);
            $em->flush();

        }

        return $this->redirectToRoute('app_transformation_index', [], Response::HTTP_SEE_OTHER);

    }

    /**
     * @Route("/{idimage}/downvote", name="app_transformation_downvote" )
     */
    public function downvote(Request $request, EntityManagerInterface $em ): Response
    {
        $idI = $request->get('idimage');
        $transformation = $this->getDoctrine()->getRepository(Transformation::class)->findOneBy(array('idimage' => $idI)) ;
        if( $transformation)
        {   $nbrlikeavant = $transformation->getTlike();
            $nbrlike = $nbrlikeavant - 1 ;
            $transformation->setTlike($nbrlike);
            $em->flush();

        }

        return $this->redirectToRoute('app_transformation_index', [], Response::HTTP_SEE_OTHER);

    }
}

