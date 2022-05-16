<?php

namespace App\Controller;

use App\Entity\Salledesport;
use App\Repository\ChallengeRepository;
use App\Repository\SalledesportRepository;
use App\Form\SalledesportType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use function mysql_xdevapi\getSession;

/**
 * @Route("/salledesport")
 */
class SalledesportController extends AbstractController
{
    /**
     * @Route("/MyGyms", name="app_salledesport_manager", methods={"GET"})
     */
    public function index(Request $request,EntityManagerInterface $entityManager): Response
    {$session = $request->getSession();
        $salledesports = $entityManager
            ->getRepository(Salledesport::class)
            ->findBy(['idResponsable' =>$session->get('iduser', 0)]);
        return $this->render('salledesport/index.html.twig', [
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
        $session = $request->getSession();
        if ($form->isSubmitted()) {
            $salledesport->setIdResponsable($session->get('iduser',0));
            $entityManager->persist($salledesport);
            $entityManager->flush();

            return $this->redirectToRoute('app_salledesport_manager', [], Response::HTTP_SEE_OTHER);
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

            return $this->redirectToRoute('app_salledesport_manager', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('salledesport/edit.html.twig', [
            'salledesport' => $salledesport,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/updategym/{iduser}", name="update_gym", methods={"GET", "POST"})
     */
    public function editsallesp($iduser,Request $request, NormalizerInterface $normalizer, SalledesportRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $nom = $request->query->get('nomsalle');
        $adresse = $request->query->get('adresse');
        $price = $request->query->get('prixseance');


        $salle= $entityManager->getRepository(Salledesport::class)->findOneBy(['idResponsable'=> $iduser]);
        $salle->setNomsalle($nom);
        $salle->setPrixseance($price);
        $salle->setAdresse($adresse);

        $entityManager->flush();
        $jsonContent=$normalizer->normalize($salle,'json');
        return new Response("User modified Sucessfully".json_encode($jsonContent));
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

        return $this->redirectToRoute('app_salledesport_manager', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/newchallenge",name="add" ,methods={"GET", "POST"})
     */
    public function newmobile(Request $request, SalledesportRepository $repository):Response
    {


        $id=$request->query->get('idmanager');
        $name=$request->query->get('nomsalle');
        $adress=$request->query->get('adresse');
      $price=$request->query->get('prixseance');

            $sallle = new Salledesport();
        $sallle->setIdResponsable($id);
        $sallle->setAdresse($adress);
        $sallle->setNomsalle($name);
        $sallle->setPrixseance($price);

            $em = $this->getDoctrine()->getManager();
            $em->persist($sallle);
            $em->flush();
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($sallle);
            return new JsonResponse($formatted);


    }
    /**
     * @Route ("/getSalle/{idsalle}", name="getsalle")
     */
    public function GetGym($idsalle,SerializerInterface $serializer,SalledesportRepository $repository):Response
    {
        $salle = $repository->findOneBy(['idSalle'=>$idsalle]);

        $json=$serializer->serialize($salle,'json');
        return  new Response($json);

    }
    /**
     * @Route ("/allmygyms/{iduser}", name="getmygyms")
     */
    public function GetAllMyGym($iduser,SerializerInterface $serializer,SalledesportRepository $repository):Response
    {
        $salle = $repository->findBy(['idResponsable'=>$iduser]);

        $json=$serializer->serialize($salle,'json');
        return  new Response($json);

    }
    /**
     * @Route("/deletemobile/{idsalle}",name="delete_challengejson" )
     */
    public function deletechallenge($idsalle,EntityManagerInterface $entityManager, Request $request, SalledesportRepository $repository): Response
    {

        $salle = $repository->findOneBy(['idSalle'=>$idsalle]);
        if ($salle != null) {
            $entityManager->remove($salle);
            $entityManager->flush();

            $serializer = new Serializer([new ObjectNormalizer()]);
            $jsonContent = $serializer->normalize("c bon");
            return new JsonResponse($jsonContent);
        }
        return new JsonResponse("non");
    }

}
