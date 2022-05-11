<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Publication;
use App\Entity\Reclamation;
use App\Entity\Suppression;
use App\Entity\User;
use App\Form\ReclamationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;



/**
 * @Route("/reclamation")
 */
class ReclamationController extends AbstractController
{
    /**
     * @Route("/", name="app_reclamation_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager,ChartBuilderInterface $chartBuilder): Response
    {

$reclamations = $entityManager
            ->getRepository(Reclamation::class)
            ->findAll();

        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamations,

        ]);
    }

    /**
     * @Route("/{id}/{idp}/new", name="app_reclamation_new", methods={"GET", "POST"})
     * @Entity("publication", expr="repository.find(idp)")
     */
    public function new(Request $request,Publication $publication,Commentaire $commentaire,EntityManagerInterface $entityManager): Response
    {
        $session = 53;
        $v = $commentaire->getIdpublication();
        $em = $this->getDoctrine()->getManager();
        $dql = "SELECT SUM(e.idcommentreclam) FROM App\Entity\Reclamation e " .
            "WHERE e.idcommentreclam = ?1 and e.idreclameur = ?2";
        $balance = $em->createQuery($dql)
            ->setParameter(1, $commentaire->getId())
            ->setParameter(2, $session)
            ->getSingleScalarResult();
        if ($balance == 0) {
            $reclamation = new Reclamation();
            $form = $this->createForm(ReclamationType::class, $reclamation);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $time = date('d/m/Y');
                $traitement = "non traite";
                $reclamation->setIdreclameur($session);
                $reclamation->setPubrec($publication->getPublication());
                $reclamation->setCommentairerec($commentaire->getCommentaire());
                $reclamation->setIduserreclamation($commentaire->getIduser());
                $reclamation->setEtatreclamation($traitement);
                $reclamation->setDatereclam($time);
                $reclamation->setIdcommentreclam($commentaire->getId());
                $entityManager->persist($reclamation);
                $entityManager->flush();
                return $this->redirectToRoute('app_publication_show', ['id' => $v], Response::HTTP_SEE_OTHER);

            }


            return $this->render('reclamation/new.html.twig', [
                'reclamation' => $reclamation,
                'form' => $form->createView(),
            ]);
        }
        return $this->redirectToRoute('app_publication_show', ['id' => $v], Response::HTTP_SEE_OTHER);

    }


    /**
     * @Route("/{idreclamation}", name="app_reclamation_show", methods={"GET"})
     */
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    /**
     * @Route("/{idreclamation}/{idCommentReclam}/edit", name="app_reclamation_edit", methods={"GET", "POST"})
     * @Entity("commentaire", expr="repository.find(idCommentReclam)")
     */
    public function edit(MailerInterface $mailer,Request $request, Reclamation $reclamation,Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager
            ->getRepository(User::class)
            ->find($reclamation->getIduserreclamation());
       /* $commentaire = $entityManager
            ->getRepository(Commentaire::class)
            ->find(idCommentReclam); */
        $email = (new TemplatedEmail())
            ->from('oakfitness.noreply@gmail.com')
            ->to($user->getMailuser())

            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('OAK team')
            ->text('FOORUM')
            ->htmlTemplate('reclamation/report.html.twig')

        ->context([
        'commentaire' => $commentaire,

    ]);
        $mailer->send($email);
        $suppression = new Suppression();
        $suppression->setIdusers($commentaire->getIduser());
        $entityManager->persist($suppression);
        $entityManager->flush();
        $em = $this->getDoctrine()->getManager();
        $dql = "SELECT SUM(e) FROM App\Entity\Suppression e " .
            "WHERE e.idusers = ?1";
        $balance = $em->createQuery($dql)
            ->setParameter(1, $commentaire->getIduser())
            ->getSingleScalarResult();
        if ($balance >= 3){

            $entityManager->remove($user);
            $entityManager->flush();
            $email = (new TemplatedEmail())
                ->from('oakfitness.noreply@gmail.com')
                ->to('oakfitness.noreply@gmail.com')

                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
                ->subject('OAK team')
                ->text('FOORUM')
                ->htmlTemplate('reclamation/report.html.twig')

                ->context([
                    'user' => $user,

                ]);

        }

       $entityManager->remove($commentaire);
             $entityManager->flush();


                 $reclamation->setEtatreclamation("traite");
                 $entityManager->flush();

            return $this->redirectToRoute('app_reclamation_index', [

            ], Response::HTTP_SEE_OTHER);

    }

    /**
     * @Route("/{idreclamation}", name="app_reclamation_delete", methods={"POST"})
     */
    public function delete(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getIdreclamation(), $request->request->get('_token'))) {
            $entityManager->remove($reclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }
}
