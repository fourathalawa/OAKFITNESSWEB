<?php

namespace App\Controller;

use App\Entity\Challenge;
use App\Entity\User;
use App\Repository\ChallengeRepository;
use App\Form\ChallengeType;
use App\Form\ChallengeNWType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\RepositoryException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/challenge")
 */
class ChallengeController extends AbstractController
{
    /**
     * @Route("/all", name="app_challenge_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $challenges = $entityManager
            ->getRepository(Challenge::class)
            ->findAll();

        return $this->render('challenge/alladherent.html.twig', [
            'challenges' => $challenges,
        ]);
    }

    /**
     * @Route("/new", name="app_challenge_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {$session=$request->getSession();
        $challenge = new Challenge();
        $form = $this->createForm(ChallengeType::class, $challenge);
        $form->handleRequest($request);

        if ($form->isSubmitted()  ) {
            $challenge->setIduser($session->get('iduser',0));
            $entityManager->persist($challenge);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_show', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('challenge/new.html.twig', [
            'challenge' => $challenge,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idchallenge}", name="app_challenge_show", methods={"GET"})
     */
    public function show(Challenge $challenge): Response
    {

        return $this->render('challenge/show.html.twig', [
            'challenge' => $challenge,

        ]);
    }

    /**
     * @Route("/{idchallenge}/edit", name="app_challenge_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Challenge $challenge, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ChallengeNWType::class, $challenge);
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_show', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('challenge/edit.html.twig', [
            'challenge' => $challenge,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idchallenge}", name="app_challenge_delete", methods={"POST"})
     */
    public function delete(Request $request, Challenge $challenge, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$challenge->getIdchallenge(), $request->request->get('_token'))) {
            $entityManager->remove($challenge);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_show', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/yourchallenge/{iduser}", name="app_challenge_userchallenge",methods={"GET","POST"})
     */
    public function yourchallenge(Request $request,ChallengeRepository $challengeRepository)
    {$session=$request->getSession();
        $challenge=$challengeRepository->findOneBy(['iduser'=>$session->get('iduser',0)]);
if( $challenge== null)
{
    return $this->redirectToRoute('app_challenge_new', [], Response::HTTP_SEE_OTHER);
}
else {
    $poidInt = $challenge->getPoidint();
    $poidObject = $challenge->getPoidob();
    $poidNv = $challenge->getPoidnv();
    $taille = $challenge->getTaille();
    $taux = 0;
    $taux2 = 0;
    if ($poidNv != null) {
        $taux = (($poidInt - $poidNv) * 100) / ($poidInt - $poidObject);
        $imcNow = $poidNv / ($taille * $taille);
        $taux2 = 100 - $taux;
    } else {
        $taux = 0;
        $imcNow = $poidInt / ($taille * $taille);
        $taux2 = 100 - $taux;
    }
    return $this->render('challenge/show.html.twig', [
        'challenge' => $challenge,
        'taux' => json_encode($taux),
        'taux2' => json_encode($taux2),
        'imcNow' => round($imcNow, 2)
    ]);
}
    }
}
