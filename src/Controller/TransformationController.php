<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Transformation;
use App\Form\ProduitType;
use App\Form\TransformationType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use phpDocumentor\Reflection\DocBlock\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

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

        $session=$request->getSession();
        $id=$session->get('iduser');
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
            'id'=>$id,
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
        $session=$request->getSession();
        $id=$session->get('iduser',0);

        if ($form->isSubmitted()) {


            $filename=$form->get('imageavant')->getData()->getClientOriginalName();
            $form->get('imageavant')->getData()->move($this->getParameter('kernel.project_dir').'/public/uploads/images',$filename);
            //end move image
            $filename1=$form->get('imageapres')->getData()->getClientOriginalName();
            $form->get('imageapres')->getData()->move($this->getParameter('kernel.project_dir').'/public/uploads/images',$filename1);
            $transformation->setImageavant($filename);
            $transformation->setImageapres($filename1);
            $transformation->setIduser($id);
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

        $oldfile=$transformation->getImageavant();
        $oldfile2=$transformation->getImageapres();
        //Move image

        if ($form->isSubmitted() && $form->isValid()) {
            $filename = $form->get('imageavant')->getData()->getClientOriginalName();
            $fileName2 = $form->get('imageapres')->getData()->getClientOriginalName();
            if($oldfile != $filename) {
                $form->get('imageavant')->getData()->move($this->getParameter('kernel.project_dir') . '/public/uploads/images', $filename);
                $transformation->setImageavant($filename);
            }
            if($oldfile2 != $fileName2) {
                $form->get('imageapres')->getData()->move($this->getParameter('kernel.project_dir') . '/public/uploads/images', $fileName2);
                $transformation->setImageapres($fileName2);
            }
            $entityManager->persist($transformation);
            $entityManager = $this->getDoctrine()->getManager();
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
    public function vote(Request $request, EntityManagerInterface $em , NormalizerInterface $Normalizer ): Response
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

    /**
     * @Route("/codename/viewt", name="viewt")
     */
    public function viewt( NormalizerInterface $Normalizer)
    {
        $repo = $this->getDoctrine()->getRepository(Transformation::class);
        $club = $repo->findAll();



        $json=$Normalizer->normalize($club,'json',['groups'=>'transformation']);


        return new Response(json_encode($json));

        dump($json);

        die;
    }

    /**
     * @Route("/codename/deletet/{idimage}", name="deletet")
     */
    public function deletet (Request $request, SerializerInterface  $serializer , EntityManagerInterface $em)
    {
        $id = $request->get("idimage");
        //$m = $this->getDoctrine();
        $club  = $this->getDoctrine()->getRepository(Transformation::class)->find($id);
        $em = $this->getDoctrine()->getManager();

        if($club != null)
        {
            $em->remove($club);
            $em->flush();
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize("Trans Deleted ");
            return new JsonResponse($formatted);
        }
        return new JsonResponse("rip");
    }

    /**
     * @Route("/codename/addt", name="addt")
     */
    public function addpJSON(Request $request, NormalizerInterface $Normalizer){
        $em=$this->getDoctrine()->getManager();
        //start move image
        $file = new File($request->query->get('imageavant'));
        $filename=$file->getFilename();
        $file->move($this->getParameter('kernel.project_dir'). '/public/uploads/images',$filename);
        //
        $file1 = new File($request->query->get('imageapres'));
        $filenam=$file1->getFilename();
        $file1->move($this->getParameter('kernel.project_dir'). '/public/uploads/images',$filenam);
        //end move image
        $Transformation= new Transformation();
        $Transformation->setTitreimage($request->get('titreimage'));
        $Transformation->setDescreptionimage($request->get('descreptionimage'));
        $Transformation->setImageavant($filename);
        $Transformation->setImageapres($filenam);
        $Transformation->setPoidavant($request->get('poidavant'));
        $Transformation->setPoidapres($request->get('poidapres'));
        $Transformation->setTailleavant($request->get('tailleavant'));
        $Transformation->setTailleapres($request->get('tailleapres'));
        $Transformation->setTlike($request->get('tlike'));
        $Transformation->setIduser($request->get('iduser'));

        $em->persist($Transformation);
        $em->flush();
        $jsonContent = $Normalizer->normalize($Transformation, 'json',['groups'=>'transforamtion']);
        return new Response("Informations ajoutées avec succès".json_encode($jsonContent));
    }

    /**
     * @Route("/codename/updatet/{idimage}", name="updatet")
     */
    public function updatet(Request $request, NormalizerInterface $Normalizer,$idimage){
        $em=$this->getDoctrine()->getManager();
        $Transformation=$em->getRepository(Transformation::class)->find($idimage);
        //start move image
        $file = new File($request->query->get('imageavant'));
        $filename=$file->getFilename();
        $file->move($this->getParameter('kernel.project_dir'). '/public/uploads/images',$filename);
        //
        $file1 = new File($request->query->get('imageapres'));
        $filenam=$file1->getFilename();
        $file1->move($this->getParameter('kernel.project_dir'). '/public/uploads/images',$filenam);
        //end move image
        //end move image
        $Transformation->setTitreimage($request->get('titreimage'));
        $Transformation->setDescreptionimage($request->get('descreptionimage'));
        $Transformation->setImageavant($filename);
        $Transformation->setImageapres($filenam);
        $Transformation->setPoidavant($request->get('poidavant'));
        $Transformation->setPoidapres($request->get('poidapres'));
        $Transformation->setTailleavant($request->get('tailleavant'));
        $Transformation->setTailleapres($request->get('tailleapres'));

        $em->flush();
        $jsonContent=$Normalizer->normalize($Transformation,'json',['groups'=>'transforamtion']);
        return new Response("Informations mises à jour avec succès".json_encode($jsonContent));
    }

    /**
     * @Route("/{idimage}/votejason", name="app_transformation_upvotej" )
     */
    public function votejason(Request $request, EntityManagerInterface $em , NormalizerInterface $Normalizer ): Response
    {
        $idI = $request->get('idimage');
        $transformation = $this->getDoctrine()->getRepository(Transformation::class)->findOneBy(array('idimage' => $idI)) ;
        if( $transformation)
        {   $nbrlikeavant = $transformation->getTlike();
            $nbrlike = $nbrlikeavant + 1 ;
            $transformation->setTlike($nbrlike);
            $em->flush();
            $jsonContent = $Normalizer->normalize($transformation, 'json',['groups'=>'transforamtion']);
            return new Response("UpVOTE avec succès".json_encode($jsonContent));
        }

        return $this->redirectToRoute('app_transformation_index', [], Response::HTTP_SEE_OTHER);

    }

    /**
     * @Route("/{idimage}/downvotejason", name="app_transformation_downvotej" )
     */
    public function downvotejason(Request $request, EntityManagerInterface $em ,NormalizerInterface $Normalizer ): Response
    {
        $idI = $request->get('idimage');
        $transformation = $this->getDoctrine()->getRepository(Transformation::class)->findOneBy(array('idimage' => $idI)) ;
        if( $transformation)
        {   $nbrlikeavant = $transformation->getTlike();
            $nbrlike = $nbrlikeavant - 1 ;
            $transformation->setTlike($nbrlike);
            $em->flush();
            $jsonContent = $Normalizer->normalize($transformation, 'json',['groups'=>'transforamtion']);
            return new Response("DownVOTE avec succès".json_encode($jsonContent));

        }

        return $this->redirectToRoute('app_transformation_index', [], Response::HTTP_SEE_OTHER);

    }
}

