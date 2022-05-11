<?php

namespace App\Controller;


use App\Entity\Publication;
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
     * @Route("/create", name="app_event_new_mobile", methods={"GET", "POST"})
     */
    public function newMobile(Request $request,USerRepository $userRepository, EntityManagerInterface $entityManager, SerializerInterface $serializer)
    {
        $session = 52;
        $user = $userRepository
            ->find($session);

        $pub = $request->query->get("publication");
        $publication = new Publication();
        $publication->setPublication($pub);
        $publication->setIduser($session);
        $time = date('d/m/Y');
        $publication->setDatepublication($time);
        $publication->setUsernamep($user->getNomuser());

        $entityManager->persist($publication);
        $entityManager->flush();
        $json = $serializer->serialize($publication, "json");
        return new Response($json);
    }
    /**
     * @Route("/deleteclub/{idpublication}", name="app_repas_delete_mobile", methods={"GET"})
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
     * @Route("/modifier/{pub}/{idpub}", name="app_repas_delete_mobile", methods={"GET"})
     */
    public function modifer(Request $request, EntityManagerInterface $entityManager,$pub,$idpub,NormalizerInterface $normalizer): Response
    {
        $publication= $entityManager->getRepository(Publication::class)->find($idpub);

        $publication->setPublication($pub);
        $entityManager->flush();
        $jsonContent=$normalizer->normalize($publication,'json');
        return new Response("Event modified Sucessfully".json_encode($jsonContent));
    }



}
