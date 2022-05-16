<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Equipes;
use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Form\ExerciceType;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @Route("/event")
 */
class EventController extends AbstractController

{
    /**
     * @Route("/allMobileJson", name="app_event_all_Mobile", methods={"GET"})
     */
    public function allMobile(EntityManagerInterface $entityManager,SerializerInterface $serializer): Response
    {
        $evenements = $entityManager
            ->getRepository(Evenement::class)
            ->findAll();
        $json=$serializer->serialize($evenements,"json");
        return new Response($json);

    }
    /**
     * @Route("/deleteMobile/{idevenement}", name="app_event_delete_mobile", methods={"GET"})
     */
    public function deleteMobile(EntityManagerInterface $entityManager,$idevenement,NormalizerInterface $normalizer): Response
    {
        $evenement = $entityManager->getRepository(Evenement::class)->find($idevenement);
        $entityManager->remove($evenement);
        $entityManager->flush();
        $jsonContent=$normalizer->normalize($evenement,'json');
        return new Response("Event deleted Sucessfully".json_encode($jsonContent));
    }
    /**
     * @Route("/newMobile", name="app_event_new_mobile", methods={"GET", "POST"})
     */
    public function newMobile(Request $request, EntityManagerInterface $entityManager,SerializerInterface $serializer): Response
    {
        $file = new File($request->query->get('image'));
        $filename=$file->getFilename();

        $file->move($this->getParameter('kernel.project_dir'). '/public/uploads/images',$filename);
        $idcreator = $request->query->get("IDCreatorEvenement");
        $titre = $request->query->get("TitreEvenement");
        $descr= $request->query->get("DescrEvenement");
        $adresse = $request->query->get("AdresseEvenement");
        $date= date_create_from_format("Y-m-d",$request->get("DateEvenement"));
        $type = $request->query->get("TypeEvenement");
        $evenement = new Evenement();
        $evenement->setIdcreatorevenement($idcreator);
        $evenement->setAdresseevenement($adresse);
        $evenement->setDateevenement($date);
        $evenement->setDescrevenement($descr);
        $evenement->setTypeevenement($type);
        $evenement->setTitreevenement($titre);
        $evenement->setImage($filename);
        $entityManager->persist($evenement);
        $entityManager->flush();
        $json=$serializer->serialize($evenement,"json");
        return new Response($json);
    }
    /**
     * @Route("/editMobile/{idevenement}", name="app_event_edit_mobile", methods={"GET", "POST"})
     */
    public function eMobile(Request $request, EntityManagerInterface $entityManager,SerializerInterface $serializer,$idevenement): Response
    {
        $file = new File($request->get('image'));
        $filename=$file->getFilename();
        $file->move($this->getParameter('kernel.project_dir'). '/public/uploads/images',$filename);
        $evenement = $entityManager->getRepository(Evenement::class)->find($idevenement);
        $idcreator = $request->query->get("IDCreatorEvenement");
        $titre = $request->query->get("TitreEvenement");
        $descr= $request->query->get("DescrEvenement");
        $adresse = $request->query->get("AdresseEvenement");
        $date= date_create_from_format("Y-m-d",$request->get("DateEvenement"));
        $type = $request->query->get("TypeEvenement");
        $evenement->setIdcreatorevenement($idcreator);
        $evenement->setAdresseevenement($adresse);
        $evenement->setDateevenement($date);
        $evenement->setDescrevenement($descr);
        $evenement->setTypeevenement($type);
        $evenement->setTitreevenement($titre);
        $evenement->setImage($filename);
        $entityManager->persist($evenement);
        $entityManager->flush();
        $json=$serializer->serialize($evenement,"json");
        return new Response($json);
    }
    /**
     * @Route("/all", name="app_event_all", methods={"GET"})
     */
    public function all(EntityManagerInterface $entityManager,Request $request): Response
    {
        $data = new SearchData();
        $data->page = $request->get('page',1);
        $form = $this->createForm(SearchType::class, $data);
        $form->handleRequest($request);
        $evenements = $entityManager
            ->getRepository(Evenement::class)
            ->filterSearch($data);

        return $this->render('event/events.html.twig', [
            'evenements' => $evenements,
            'form' =>$form->createView()
        ]);
    }
    /**
     * @Route("/", name="app_event_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager,Request $request): Response
    {
        $data = new SearchData();
        $data->page = $request->get('page',1);
        $form = $this->createForm(SearchType::class, $data);
        $form->handleRequest($request);
        $evenements = $entityManager
            ->getRepository(Evenement::class)
            ->filterSearch($data);

        return $this->render('event/index.html.twig', [
            'evenements' => $evenements,
            'form' =>$form->createView()
        ]);
    }

    /**
     * @Route("/new", name="app_event_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement,[
            'entity_manager' => $entityManager,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Move image
            $filename=$form->get('image')->getData()->getClientOriginalName();
            $form->get('image')->getData()->move($this->getParameter('kernel.project_dir'). '/public/uploads/images',$filename);
            //end move image
            $evenement->setImage($filename);
            $entityManager->persist($evenement);
            $entityManager->flush();


            return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('event/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idevenement}", name="app_event_show", methods={"GET"})
     */
    public function show(Evenement $evenement): Response
    {
        return $this->render('event/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    /**
     * @Route("/{idevenement}/edit", name="app_event_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        $oldfile=$evenement->getImage();
        $form = $this->createForm(EvenementType::class, $evenement,[
            'entity_manager' => $entityManager,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Move image
            $filename = $form->get('image')->getData()->getClientOriginalName();
            if($oldfile != $filename) {
                $form->get('image')->getData()->move($this->getParameter('kernel.project_dir') . '/public/uploads/images', $filename);
                $evenement->setImage($filename);
            }
            //end move image
            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('event/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{idevenement}", name="app_event_delete", methods={"POST"})
     */
    public function delete(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getIdevenement(), $request->request->get('_token'))) {
            $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
    }



}