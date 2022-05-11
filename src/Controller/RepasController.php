<?php

namespace App\Controller;

use App\Entity\Repas;
use App\Form\ExerciceType;
use App\Form\RepasType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/repas")
 */
class RepasController extends AbstractController
{
    /**
     * @Route("/all/downloadpdf", name="app_repas_all_download", methods={"GET"})
     */
    public function  downloadall(\Knp\Snappy\Pdf $snappy,Request $request,EntityManagerInterface $entityManager): Response
    {
        $repas = $entityManager
            ->getRepository(Repas::class)
            ->findAll();

        $html =  $this->render('repas/pdfall.html.twig', [
            'repas' => $repas,
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
     * @Route("/allMobileJson", name="app_repa_all_Mobile", methods={"GET"})
     */
    public function allMobile(EntityManagerInterface $entityManager,SerializerInterface $serializer): Response
    {
        $repas = $entityManager
            ->getRepository(Repas::class)
            ->findAll();
        $json=$serializer->serialize($repas,"json");
        return new Response($json);

    }
    /**
     * @Route("/newMobile", name="app_repas_new_mobile", methods={"GET", "POST"})
     */
    public function newMobile(Request $request, EntityManagerInterface $entityManager,SerializerInterface $serializer)
    {
        $pdej = $request->query->get("PDej");
        $dej = $request->query->get("Dej");
        $din= $request->query->get("Dinn");
        $calorie = $request->query->get("Calorie");
        $rest = $request->query->get("RestOrActive");
        $repa = new Repas();
        $repa->setCalorie($calorie);
        $repa->setDej($dej);
        $repa->setPdej($pdej);
        $repa->setDinn($din);
        $repa->setRestoractive($rest);
        $entityManager->persist($repa);
        $entityManager->flush();
        $json=$serializer->serialize($repa,"json");
        return new Response($json);
    }
    /**
     * @Route("/all", name="app_repas_all", methods={"GET"})
     */
    public function all(EntityManagerInterface $entityManager): Response
    {
        $repas = $entityManager
            ->getRepository(Repas::class)
            ->findAll();

        return $this->render('repas/repas.html.twig', [
            'repas' => $repas,
        ]);
    }
    /**
     * @Route("/", name="app_repas_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $repas = $entityManager
            ->getRepository(Repas::class)
            ->findAll();

        return $this->render('repas/index.html.twig', [
            'repas' => $repas,
        ]);
    }

    /**
     * @Route("/new", name="app_repas_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $repa = new Repas();
        $form = $this->createForm(RepasType::class, $repa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Move image
            $filename=$form->get('image')->getData()->getClientOriginalName();
            $form->get('image')->getData()->move($this->getParameter('kernel.project_dir'). '/public/uploads/images',$filename);
            //end move image
            $repa->setImage($filename);
            $entityManager->persist($repa);
            $entityManager->flush();

            return $this->redirectToRoute('app_repas_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('repas/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idrepas}", name="app_repas_show", methods={"GET"})
     */
    public function show(EntityManagerInterface $entityManager,$idrepas): Response
    {
        $repa = $entityManager
            ->getRepository(Repas::class)
            ->find($idrepas);
        return $this->render('repas/show.html.twig', [
            'repa' => $repa,
        ]);
    }
    /**
     * @Route("/Mobile/{idrepas}", name="app_repas_show_mobile", methods={"GET"})
     */
    public function showMobile(EntityManagerInterface $entityManager,$idrepas,SerializerInterface $serializer): Response
    {
        $repa = $entityManager
            ->getRepository(Repas::class)
            ->find($idrepas);
        $json=$serializer->serialize($repa,"json");
        return new Response($json);

    }

    /**
     * @Route("/{idrepas}/edit", name="app_repas_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Repas $repa, EntityManagerInterface $entityManager): Response
    {
        $oldfile=$repa->getImage();
        $form = $this->createForm(RepasType::class, $repa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Move image
            $filename = $form->get('image')->getData()->getClientOriginalName();
            if($oldfile != $filename) {
                $form->get('image')->getData()->move($this->getParameter('kernel.project_dir') . '/public/uploads/images', $filename);
                $repa->setImage($filename);
            }
            //end move image
            $entityManager->persist($repa);
            $entityManager->flush();
            return $this->redirectToRoute('app_repas_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('repas/edit.html.twig', [
            'repa' => $repa,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idrepas}", name="app_repas_delete", methods={"POST"})
     */
    public function delete(Request $request, Repas $repa, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$repa->getIdrepas(), $request->request->get('_token'))) {
            $entityManager->remove($repa);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_repas_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/{idrepas}/downloadpdf", name="app_repa_show_download")
     */
    public function download(\Knp\Snappy\Pdf $snappy,Request $request,$idrepas,EntityManagerInterface $entityManager): Response
    {
        $repa = $entityManager
            ->getRepository(Repas::class)
            ->find($idrepas);
        $html = $this->renderView('repas/pdf.html.twig', [
            'repa' => $repa,
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
     * @Route("/deleteMobile/{idrepas}", name="app_repas_delete_mobile", methods={"GET"})
     */
    public function deleteMobile(Request $request, EntityManagerInterface $entityManager,$idrepas,NormalizerInterface $normalizer): Response
    {
        $repas = $entityManager->getRepository(Repas::class)->find($idrepas);

        $entityManager->remove($repas);
        $entityManager->flush();
        $jsonContent=$normalizer->normalize($repas,'json');
        return new Response("Event deleted Sucessfully".json_encode($jsonContent));
    }
}
