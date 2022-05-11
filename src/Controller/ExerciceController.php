<?php

namespace App\Controller;

use App\Entity\Exercice;
use App\Entity\Image;
use App\Form\ExerciceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/exercice")
 */
class ExerciceController extends AbstractController
{
    /**
     * @Route("/allMobileJson", name="app_exercice_all_Mobile", methods={"GET"})
     */
    public function allMobile(EntityManagerInterface $entityManager,SerializerInterface $serializer): Response
    {
        $exercice = $entityManager
            ->getRepository(Exercice::class)
            ->findAll();
        $json=$serializer->serialize($exercice,"json");
        return new Response($json);

    }
    /**
     * @Route("/all", name="app_exercice_all", methods={"GET"})
     */
    public function  all(EntityManagerInterface $entityManager): Response
    {
        $exercices = $entityManager
            ->getRepository(Exercice::class)
            ->findAll();

        return $this->render('exercice/exercices.html.twig', [
            'exercices' => $exercices,
        ]);
    }
    /**
     * @Route("/all/downloadpdf", name="app_exercice_all_download", methods={"GET"})
     */
    public function  downloadall(\Knp\Snappy\Pdf $snappy,Request $request,EntityManagerInterface $entityManager): Response
    {
        $exercices = $entityManager
            ->getRepository(Exercice::class)
            ->findAll();

        $html =  $this->render('exercice/pdfall.html.twig', [
            'exercices' => $exercices,
        ]);
        $filename = "downloadedpdfall";
        $snappy->setOption('enable-local-file-access', true);
        $snappy->setOption('no-outline', true);
        $snappy->setOption('page-size','LETTER');
        $snappy->setOption('encoding', 'UTF-8');
        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="'.$filename.'.pdf"'
            )
        );

    }
    /**
     * @Route("/", name="app_exercice_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $exercices = $entityManager
            ->getRepository(Exercice::class)
            ->findAll();

        return $this->render('exercice/index.html.twig', [
            'exercices' => $exercices,
        ]);
    }
    /**
     * @Route("/newMobile", name="app_exercice_new_mobile", methods={"GET", "POST"})
     */
    public function newMobile(Request $request, EntityManagerInterface $entityManager,SerializerInterface $serializer)
    {
        $type = $request->query->get("TypeExercice");
        $nom = $request->query->get("NomExercice");
        $muscle= $request->query->get("Muscle");
        $video = $request->query->get("video");
        $dscr = $request->query->get("DescrExercice");
        $diff= $request->query->get("DiffExercice");
        $gym = $request->query->get("JusteSalleExercice");
        $length = $request->query->get("DureeExercice");
        $exercice = new Exercice();
        $exercice->setTypeexercice($type);
        $exercice->setDescrexercice($dscr);
        $exercice->setDiffexercice($diff);
        $exercice->setDureeexercice($length);
        $exercice->setNomexercice($nom);
        $exercice->setMuscle($muscle);
        $exercice->setVideo($video);
        $exercice->setJustesalleexercice($gym);
        $entityManager->persist($exercice);
        $entityManager->flush();
        $json=$serializer->serialize($exercice,"json");
        return new Response($json);
    }
    /**
     * @Route("/new", name="app_exercice_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $exercice = new Exercice();
        $form = $this->createForm(ExerciceType::class, $exercice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Move image
            $filename=$form->get('image')->getData()->getClientOriginalName();
            $form->get('image')->getData()->move($this->getParameter('kernel.project_dir'). '/public/uploads/images',$filename);
            //end move image
            $exercice->setImage($filename);
            $entityManager->persist($exercice);
            $entityManager->flush();

            return $this->redirectToRoute('app_exercice_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('exercice/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idexercice}", name="app_exercice_show", methods={"GET"})
     */
    public function show(EntityManagerInterface $entityManager,$idexercice): Response
    {
        $exercice = $entityManager
            ->getRepository(Exercice::class)
            ->find($idexercice);

        return $this->render('exercice/show.html.twig', [
            'exercice' => $exercice,
        ]);
    }

    /**
     * @Route("/{idexercice}/edit", name="app_exercice_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Exercice $exercice, EntityManagerInterface $entityManager): Response
    {
        $oldfile=$exercice->getImage();
        $form = $this->createForm(ExerciceType::class, $exercice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Move image
            $filename = $form->get('image')->getData()->getClientOriginalName();
            if($oldfile != $filename) {
                $form->get('image')->getData()->move($this->getParameter('kernel.project_dir') . '/public/uploads/images', $filename);
                $exercice->setImage($filename);
            }
            //end move image
            $entityManager->persist($exercice);
            $entityManager->flush();

            return $this->redirectToRoute('app_exercice_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->render('exercice/edit.html.twig', [
            'exercice' => $exercice,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idexercice}", name="app_exercice_delete", methods={"POST"})
     */
    public function delete(Request $request, Exercice $exercice, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$exercice->getIdexercice(), $request->request->get('_token'))) {
            $entityManager->remove($exercice);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_exercice_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/{idexercice}/downloadpdf", name="app_exercice_show_download")
     */
    public function download(\Knp\Snappy\Pdf $snappy,Request $request,$idexercice,EntityManagerInterface $entityManager): Response
    {
        $exercice = $entityManager
            ->getRepository(Exercice::class)
            ->find($idexercice);
        $html = $this->renderView('exercice/pdf.html.twig', [
            'exercice' => $exercice,
        ]);
        $filename = "downloadedpdf";
        $snappy->setOption('enable-local-file-access', true);
        $snappy->setOption('no-outline', true);
        $snappy->setOption('page-size','LETTER');
        $snappy->setOption('encoding', 'UTF-8');
        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="'.$filename.'.pdf"'
            )
        );


    }
    /**
     * @Route("/deleteMobile/{idexercice}", name="app_exercice_delete_mobile", methods={"GET"})
     */
    public function deleteMobile(Request $request, EntityManagerInterface $entityManager,$idexercice,NormalizerInterface $normalizer): Response
    {
        $exercice = $entityManager->getRepository(Exercice::class)->find($idexercice);
        $entityManager->remove($exercice);
        $entityManager->flush();
        $jsonContent=$normalizer->normalize($exercice,'json');
        return new Response("Event deleted Sucessfully".json_encode($jsonContent));
    }

}
