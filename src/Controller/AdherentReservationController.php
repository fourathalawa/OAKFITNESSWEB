<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/adherent/reservation")
 */
class AdherentReservationController extends AbstractController
{
    /**
     * @Route("/{page<\d+>}", name="app_adherent_reservation")
     */
    public function index(ReservationRepository $reservationRepository, UserRepository $userRepository, int $page=1): Response
    {
        $user = $userRepository->findOneBy(['nomuser'=>'mahdi']);
//        dd($reservationRepository->findReservationByUser($user->getIduser()));
        $reservations = $reservationRepository->findReservationByUser($user->getIduser());
        $pagerfanta = new Pagerfanta(new QueryAdapter($reservations));
        $pagerfanta->setMaxPerPage(4);
        $pagerfanta->setCurrentPage($page);
        return $this->render('adherent_reservation/index.html.twig', [
            'controller_name' => 'AdherentReservationController',
            'reservations' => $pagerfanta
        ]);
    }


    /**
     * @Route("/new", name="app_reservation_client_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $user = $userRepository->findOneBy(['nomuser'=>'mahdi']);
//        dd($user);
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservation->setAcccoach(0);
            $reservation->setAccresponsable(0);
            $reservation->setIduser($user);
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('app_adherent_reservation', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('adherent_reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

}
