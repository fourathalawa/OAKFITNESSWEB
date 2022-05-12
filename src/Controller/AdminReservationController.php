<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationCoachType;
use App\Form\ReservationResponsableType;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/reservation")
 */
class AdminReservationController extends AbstractController
{
    /**
     * @Route("/", name="app_reservation_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $reservations = $entityManager
            ->getRepository(Reservation::class)
            ->findAll();

        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }
    /**
     * @Route("/coach", name="app_reservation_coach_index", methods={"GET"})
     */
    public function indexCoach(EntityManagerInterface $entityManager): Response
    {
        $reservations = $entityManager
            ->getRepository(Reservation::class)
            ->findAll();

        return $this->render('reservation/coach.html.twig', [
            'reservations' => $reservations,
        ]);
    }
    /**
     * @Route("/responsable", name="app_reservation_responsable_index", methods={"GET"})
     */
    public function indexResponsable(EntityManagerInterface $entityManager): Response
    {
        $reservations = $entityManager
            ->getRepository(Reservation::class)
            ->findAll();

        return $this->render('reservation/responsable.html.twig', [
            'reservations' => $reservations,
        ]);
    }

//    /**
//     * @Route("/new", name="app_reservation_new", methods={"GET", "POST"})
//     */
//    public function new(Request $request, EntityManagerInterface $entityManager): Response
//    {
//        $reservation = new Reservation();
//        $form = $this->createForm(ReservationType::class, $reservation);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $entityManager->persist($reservation);
//            $entityManager->flush();
//
//            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
//        }
//
//        return $this->render('reservation/new.html.twig', [
//            'reservation' => $reservation,
//            'form' => $form->createView(),
//        ]);
//    }

    /**
     * @Route("/{idreservation}", name="app_reservation_show", methods={"GET"})
     */
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    /**
     * @Route("resp/{idreservation}", name="app_reservation_show_resp", methods={"GET"})
     */
    public function showResp(Reservation $reservation): Response
    {
        return $this->render('reservation/showResp.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    /**
     * @Route("coach/{idreservation}", name="app_reservation_coach_show", methods={"GET"})
     */
    public function showCoach(Reservation $reservation): Response
    {
        return $this->render('reservation/showCoach.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    /**
     * @Route("coach/{idreservation}/edit", name="app_reservation_coach_edit", methods={"GET", "POST"})
     */
    public function cAccepterRefuser(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReservationCoachType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_coach_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]   );
    }

    /**
     * @Route("responsable/{idreservation}/edit", name="app_reservation_responsable_edit", methods={"GET", "POST"})
     */
    public function rAccepterRefuser(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReservationResponsableType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_responsable_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]   );
    }

    /**
     * @Route("/{idreservation}", name="app_reservation_delete", methods={"POST"})
     */
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getIdreservation(), $request->request->get('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }
}
