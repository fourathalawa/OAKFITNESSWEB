<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\User;
use App\Entity\Notecommentaire;
use App\Entity\Publication;
use App\Form\Commentaire1Type;
use App\Form\Publication1Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/publication")
 */
class PublicationController extends AbstractController
{
    /**
     * @Route("/", name="app_publication_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager,Request $request): Response
    {
        $session=$request->getSession();
        $publications = $entityManager
            ->getRepository(Publication::class)
            ->findAll();

        return $this->render('publication/index.html.twig', [
            'publications' => $publications,
            'session' => $session->get('iduser')
        ]);
    }
    /**
     * @Route("/new", name="app_publication_new", methods={"GET", "POST"})
     */
    public function new(Request $request,USerRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
       // $user = new User();
        $session=$request->getSession();
        $user = $userRepository
            ->find($session->get('iduser'));


        $publication = new Publication();
        $form = $this->createForm(Publication1Type::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $time = date('d/m/Y');
            $publication->setDatepublication($time);
            $publication->setIduser($session->get('iduser'));
            $publication->setUsernamep($user->getNomuser());
            $entityManager->persist($publication);
            $entityManager->flush();

            return $this->redirectToRoute('app_publication_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('publication/new.html.twig', [
            'publication' => $publication,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/", name="app_publication_show", methods={"GET" , "POST"})
     */
    public function show(Publication $publication,Request $request,USerRepository $userRepository, EntityManagerInterface $entityManager,$id): Response
    {
        $session = $request->getSession();
        $user = $userRepository
            ->find($session->get('iduser'));
        $commentaires = $entityManager
        ->getRepository(Commentaire::class)
        ->findAll();
        $output = array();
        foreach($commentaires as $commentaire)
        {
            if($publication->getId()==$commentaire->getIdpublication()) {
                $em = $this->getDoctrine()->getManager();
         //       $qb = $em->createQueryBuilder();
                $dql = "SELECT SUM(e.islike) FROM App\Entity\Notecommentaire e " .
                    "WHERE e.idcommentaire = ?1";
                $balance = $em->createQuery($dql)
                    ->setParameter(1, $commentaire->getId())
                    ->getSingleScalarResult();
                $output[] = array($balance,$commentaire->getCommentaire(), $commentaire->getDatecommentaire(),$commentaire->getId(),$commentaire->getUsernamep(),$commentaire->getIduser());
            }
        }
        $commentaires = $entityManager
        ->getRepository(Commentaire::class)
        ->findAll();
        $commentaire = new Commentaire();
        $form = $this->createForm(Commentaire1Type::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire->setIdpublication($id);
            $time = date('d/m/Y');
            $commentaire->setDatecommentaire($time);
            $commentaire->setIduser($session->get('iduser'));
            $commentaire->setUsernamep($user->getNomuser());
            $entityManager->persist($commentaire);
            $entityManager->flush();
            return $this->redirectToRoute('app_publication_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
            return $this->render('publication/show.html.twig', [
                'outputs' => $output,
                'publication' => $publication,
                'commentaires' => $commentaires,
                'session' => $session->get('iduser'),
                'form' => $form->createView(),
            ]);
        }

    /**
     * @Route("/{id}/edit", name="app_publication_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Publication $publication, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Publication1Type::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_publication_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('publication/edit.html.twig', [
            'publication' => $publication,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("dell/{id}", name="dell", methods={"POST"})
     */
    public function delete(Request $request, Publication $publication, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$publication->getId(), $request->request->get('_token'))) {
            $entityManager->remove($publication);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_publication_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/like", name="app_like", methods={"GET", "POST"})
     */
    public function like(Request $request,Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {
        $session = $request->getSession();
        $v = $commentaire->getIdpublication();

        $notecommentaire = $entityManager
            ->getRepository(Notecommentaire::class)
            ->findAll();
        $balance = 0;
        foreach($notecommentaire as $notecommentaires)
        {
                $em = $this->getDoctrine()->getManager();
                //       $qb = $em->createQueryBuilder();
                $dql = "SELECT SUM(e.islike) FROM App\Entity\Notecommentaire e " .
                    "WHERE e.idcommentaire = ?1 AND e.userid = ?2";

                $balance = $em->createQuery($dql)
                    ->setParameter(1, $commentaire->getId())
                    ->setParameter(2, $session->get('iduser'))
                    ->getSingleScalarResult();

            }
        if($balance<1) {

            $notecommentaire = new Notecommentaire();
            $notecommentaire->setIdcommentaire($commentaire->getId());
            $notecommentaire->setUserid($session->get('iduser'));
            $notecommentaire->setIslike(1);
            $entityManager->persist($notecommentaire);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_publication_show', ['id' => $v], Response::HTTP_SEE_OTHER);

    }
    /**
     * @Route("/{id}/dislike", name="app_dislike", methods={"GET", "POST"})
     */
    public function dislike(Request $request,Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {
        $session =$request->getSession();

        $v = $commentaire->getIdpublication();
        $notecommentaire = $entityManager
            ->getRepository(Notecommentaire::class)
            ->findAll();
        $balance = 0;
        foreach($notecommentaire as $notecommentaires)
        {
            $em = $this->getDoctrine()->getManager();
            //       $qb = $em->createQueryBuilder();
            $dql = "SELECT SUM(e.islike) FROM App\Entity\Notecommentaire e " .
                "WHERE e.idcommentaire = ?1 AND e.userid = ?2";

            $balance = $em->createQuery($dql)
                ->setParameter(1, $commentaire->getId())
                ->setParameter(2, $session->get('iduser'))
                ->getSingleScalarResult();

        }
        if($balance>-1 || $balance==0) {
            $notecommentaire = new Notecommentaire();
            $notecommentaire->setIdcommentaire($commentaire->getId());
            $notecommentaire->setUserid($session->get('iduser'));
            $notecommentaire->setIslike(-1);
            $entityManager->persist($notecommentaire);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_publication_show', ['id' => $v], Response::HTTP_SEE_OTHER);

    }
    /**
     * Creates a new ActionItem entity.
     *
     * @Route("/search", name="ajax_search")
     * @Method("GET")
     */
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $requestString = $request->get('q');

        $entities =  $em->getRepository('AppBundle:Entity')->findEntitiesByString($requestString);

        if(!$entities) {
            $result['entities']['error'] = "keine Einträge gefunden";
        } else {
            $result['entities'] = $this->getRealEntities($entities);
        }

        return new Response(json_encode($result));
    }

    public function getRealEntities($entities){

        foreach ($entities as $entity){
            $realEntities[$entity->getId()] = $entity->getFoo();
        }

        return $realEntities;
    }
    /**
     * @Route("/liste", name="liste")
     */
    public function getPubs(EntityManagerInterface $entityManager)
    {
        $publications = $entityManager
            ->getRepository(Publication::class)
            ->findAll();
        dump($publications);
        die();
    }

}
