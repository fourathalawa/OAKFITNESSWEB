<?php

namespace App\Controller;


use App\Entity\Commentaire;
use App\Entity\Publication;
use App\Entity\Reclamation;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;




/**
 * @Route("/liste")
 */
class testController extends AbstractController
{
    /**
     * @Route("/", name="listev")
     */
    public function getPubs(EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $publications = $entityManager
            ->getRepository(Publication::class)
            ->findAll();
        $json = $serializer->serialize($publications, 'json', ['groups' => 'publication']);
        return new Response($json);
        // dump($json);
        //  die();
    }

    /**
     * @Route("/add", name="listea")
     */
    public function addpub(EntityManagerInterface $entityManager, Request $request, SerializerInterface $serializer)
    {
        $content = $request->getContent();
        $data = $serializer->deserialize($content, Publication::class, 'json');
        $entityManager->persist($data);
        $entityManager->flush();
        return new Response('publication added succeessfully');
    }

    /**
     * @Route("/create/{sess}", name="newpub", methods={"GET", "POST"})
     */
    public function newMobile(Request $request,$sess,USerRepository $userRepository, EntityManagerInterface $entityManager, SerializerInterface $serializer)
    {
        $user = $userRepository
            ->find($sess);

        $pub = $request->query->get("publication");
        $publication = new Publication();
        $publication->setPublication($pub);
        $publication->setIduser($sess);
        $time = date('d/m/Y');
        $publication->setDatepublication($time);
        $publication->setUsernamep($user->getNomuser());

        $entityManager->persist($publication);
        $entityManager->flush();
        $json = $serializer->serialize($publication, "json");
        return new Response($json);
    }
    /**
     * @Route("/deleteclub/{idpublication}", name="deletepub", methods={"GET"})
     */
    public function deleteMobile(Request $request, EntityManagerInterface $entityManager,$idpublication,NormalizerInterface $normalizer): Response
    {
        $publication= $entityManager->getRepository(Publication::class)->find($idpublication);

        $entityManager->remove($publication);
        $entityManager->flush();
        $jsonContent=$normalizer->normalize($publication,'json');
        return new Response("Event deleted Sucessfully".json_encode($jsonContent));
    }
    /**
     * @Route("/modifier/{pub}/{idpub}", name="modifierpub", methods={"GET"})
     */
    public function modifer(Request $request, EntityManagerInterface $entityManager,$pub,$idpub,NormalizerInterface $normalizer): Response
    {
        $publication= $entityManager->getRepository(Publication::class)->find($idpub);

        $publication->setPublication($pub);
        $entityManager->flush();
        $jsonContent=$normalizer->normalize($publication,'json');
        return new Response("Event modified Sucessfully".json_encode($jsonContent));
    }
    /**
     * @Route("/comment/{idpublication}", name="newcomment", methods={"GET"})
     */
    public function comment(Request $request,$idpublication, EntityManagerInterface $entityManager,NormalizerInterface $normalizer,SerializerInterface $serializer): Response
    {
        $publication= $entityManager->getRepository(Publication::class)->find($idpublication);
        $em = $this->getDoctrine()->getManager();
        //       $qb = $em->createQueryBuilder();
        $dql = "SELECT e FROM App\Entity\Commentaire e " .
            "WHERE e.idpublication = ?1";

        $balance = $em->createQuery($dql)
            ->setParameter(1, $publication->getId())
            ->getResult();

        $json = $serializer->serialize($balance, 'json', ['groups' => 'commentaire']);
        return new Response($json);
    }
    /**
     * @Route("/createcomm/{idp}/{sess}", name="app_new_comment", methods={"GET", "POST"})
     */
    public function newComment(Request $request,$sess,$idp,USerRepository $userRepository, EntityManagerInterface $entityManager, SerializerInterface $serializer)
    {
        $user = $userRepository
            ->find($sess);

        $com = $request->query->get("commentaire");
        $comment = new Commentaire();
        $comment->setCommentaire($com);
        $comment->setIduser($sess);
        $time = date('d/m/Y');
        $comment->setDatecommentaire($time);
        $comment->setUsernamep($user->getNomuser());
        $comment->setIdpublication($idp);

        $entityManager->persist($comment);
        $entityManager->flush();
        $json = $serializer->serialize($comment, "json");
        return new Response($json);
    }

    /**
     * @Route("/deletecomment/{idcomm}", name="app_delete_comment", methods={"GET"})
     */
    public function delteComm(Request $request, EntityManagerInterface $entityManager,$idcomm,NormalizerInterface $normalizer): Response
    {
        $Commentaire= $entityManager->getRepository(Commentaire::class)->find($idcomm);
        $entityManager->remove($Commentaire);
        $entityManager->flush();
        $jsonContent=$normalizer->normalize($Commentaire,'json');
        return new Response("Event deleted Sucessfully".json_encode($jsonContent));
    }
    /**
     * @Route("/modifierC/{comm}/{idcomm}", name="app_edit_comment", methods={"GET"})
     */
    public function modiferC(Request $request, EntityManagerInterface $entityManager,$comm,$idcomm,NormalizerInterface $normalizer): Response
    {
        $Commentaire= $entityManager->getRepository(Commentaire::class)->find($idcomm);

        $Commentaire->setCommentaire($comm);
        $entityManager->flush();
        $jsonContent=$normalizer->normalize($Commentaire,'json');
        return new Response("Event modified Sucessfully".json_encode($jsonContent));
    }
    /**
     * @Route("/addreclam/{com}/{desc}/{idc}", name="addreclam", methods={"GET", "POST"})
     */
    public function newReclam(Request $request,$idc,$com,$desc,USerRepository $userRepository, EntityManagerInterface $entityManager, SerializerInterface $serializer)
    {

        $reclamation = new Reclamation();
        $reclamation->setCommentairerec($com);
        $reclamation->setDescrreclam($desc);
        $reclamation->setIdcommentreclam($idc);

        $entityManager->persist($reclamation);
        $entityManager->flush();
        $json = $serializer->serialize($reclamation, "json");
        return new Response($json);
    }
    /**
     * @Route("/reclam", name="listreports")
     */
    public function getReclams(EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $publications = $entityManager
            ->getRepository(Reclamation::class)
            ->findAll();
        $json = $serializer->serialize($publications, 'json', ['groups' => 'reclamation']);
        return new Response($json);
        // dump($json);
        //  die();
    }

}