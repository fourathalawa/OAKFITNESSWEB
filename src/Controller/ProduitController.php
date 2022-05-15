<?php

namespace App\Controller;
use phpDocumentor\Reflection\DocBlock\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Produit;
use App\Form\ProduitType;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
// Include Dompdf required namespaces
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Validator\Constraints\Json;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpFoundation\File\File;


/**
 * @Route("/produit")
 */
class ProduitController extends AbstractController
{
    /**
     * @Route("/", name="app_produit_indexback", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager  ): Response
    {
        $produits = $entityManager
            ->getRepository(Produit::class)
            ->findAll();


        return $this->render('produit/index.html.twig', [
            'produits' => $produits,
        ]);
    }

    /**
     * @Route("/listclient", name="app_produit_indexfront")
     */
    public function in(Request $request, PaginatorInterface $paginator,SerializerInterface $SerializerInterface): Response
    {
        $donnes = $this->getDoctrine()
            ->getRepository(Produit::class)
            ->findAll();

        $produits= $paginator->paginate(
            $donnes, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3 // Nombre de résultats par page
        );
        return $this->render('produit/listclient.html.twig', [
            'produits' => $produits,
        ]);
    }

    /**
     * @Route("/new", name="app_produit_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            //Move image
            $filename=$form->get('imageproduit')->getData()->getClientOriginalName();
            $form->get('imageproduit')->getData()->move($this->getParameter('kernel.project_dir'). '/public/uploads/images',$filename);
            //end move image
            $produit->setImageproduit($filename);
            $entityManager->persist($produit);
            $entityManager->flush();
            return $this->redirectToRoute('app_produit_indexback', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idproduit}", name="app_produit_showb", methods={"GET"})
     */
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    /**
     * @Route("/back/{idproduit}", name="app_produit_showf", methods={"GET"})
     */
    public function af(Produit $produit): Response
    {
        return $this->render('produit/showfront.html.twig', [
            'produit' => $produit,
        ]);
    }

    /**
     * @Route("/{idproduit}/edit", name="app_produit_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {   $oldfile=$produit->getImageproduit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        //start move image

        if ($form->isSubmitted() && $form->isValid()) {
            $filename = $form->get('imageproduit')->getData()->getClientOriginalName();
            if($oldfile != $filename) {
                $form->get('imageproduit')->getData()->move($this->getParameter('kernel.project_dir') . '/public/uploads/images', $filename);
                $produit->setImageproduit($filename);
            }
            $entityManager->persist($produit);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();


            return $this->redirectToRoute('app_produit_indexback', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idproduit}", name="app_produit_delete", methods={"POST"})
     */
    public function delete(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getIdproduit(), $request->request->get('_token'))) {
            $entityManager->remove($produit);
            $entityManager->flush();


        }

        return $this->redirectToRoute('app_produit_indexback', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/pdf/listpdfproduit" , name="app_produit_list" ,methods={"GET"} )
     */
    public function listpdfproduit(EntityManagerInterface $entityManager): Response
    {    // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $produits = $entityManager
            ->getRepository(Produit::class)
            ->findAll();



        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('produit/listpdfproduit.html.twig', [
            'produits' => $produits,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("productlistpdf.pdf", [
            "Attachment" => true
        ]);
    }

    /**
     * @Route("/codename/viewp", name="viewp" )
     */
    public function viewp( NormalizerInterface $Normalizer)
    {
        $repo = $this->getDoctrine()->getRepository(Produit::class);
        $club = $repo->findAll();



        $json=$Normalizer->normalize($club,'json',['groups'=>'produit']);


        return new Response(json_encode($json));

        dump($json);

        die;
    }


    /**
     * @Route("/codename/deletep/{idproduit}", name="deletep")
     */
    public function deletep (Request $request, SerializerInterface  $serializer , EntityManagerInterface $em)
    {
        $id = $request->get("idproduit");
        //$m = $this->getDoctrine();
        $club  = $this->getDoctrine()->getRepository(Produit::class)->find($id);
        $em = $this->getDoctrine()->getManager();

        if($club != null)
        {
            $em->remove($club);
            $em->flush();
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize("Product Deleted ");
            return new JsonResponse($formatted);
        }
         return new JsonResponse("rip");
    }

    /**
     * @Route("/codename/addp", name="addp" )
     */
    public function addp(Request $request, NormalizerInterface $Normalizer){
        $em=$this->getDoctrine()->getManager();
        //start move image
        $file = new File($request->query->get('imageproduit'));
        $filename=$file->getFilename();
        $file->move($this->getParameter('kernel.project_dir'). '/public/uploads/images',$filename);
        //end move image
        $produit= new Produit();
        $produit->setNomproduit($request->get('nomproduit'));
        $produit->setCategproduit($request->get('categproduit'));
        $produit->setDescrproduit($request->get('descrproduit'));
        $produit->setPrixproduit($request->get('prixproduit'));
        $produit->setIsavailable($request->get('isavailable'));
        $produit->setImageproduit($filename);
        $produit->setStockproduit($request->get('stockproduit'));

        $em->persist($produit);
        $em->flush();
        $jsonContent = $Normalizer->normalize($produit, 'json',['groups'=>'produit']);
        return new Response("Informations ajoutées avec succès".json_encode($jsonContent));
}
    /**
     * @Route("/codename/updatep/{idproduit}", name="updatep")
     */
    public function updatep(Request $request, NormalizerInterface $Normalizer,$idproduit){
        $em=$this->getDoctrine()->getManager();
        $produit=$em->getRepository(Produit::class)->find($idproduit);
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        //start move image
        $file = new File($request->query->get('imageproduit'));
        $filename=$file->getFilename();
        $file->move($this->getParameter('kernel.project_dir'). '/public/uploads/images',$filename);
        //end move image
        $produit->setNomproduit($request->get('nomproduit'));
        $produit->setCategproduit($request->get('categproduit'));
        $produit->setDescrproduit($request->get('descrproduit'));
        $produit->setPrixproduit($request->get('prixproduit'));
        $produit->setIsavailable($request->get('isavailable'));
        $produit->setImageproduit($filename);
        $produit->setStockproduit($request->get('stockproduit'));

        $em->flush();
        $jsonContent=$Normalizer->normalize($produit,'json',['groups'=>'produit']);
        return new Response("Informations mises à jour avec succès".json_encode($jsonContent));
    }

}