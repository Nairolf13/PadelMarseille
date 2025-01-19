<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingController extends AbstractController
{
    #[Route('/reservation', name: 'app_booking')]
    public function index(ReservationRepository $reservationRepository, Security $security): Response
    {
        $admin = $security->getUser();
        
        if (!$admin) {
            return $this->redirectToRoute('app_login');
        }

        $reservations = $reservationRepository->findFutureReservations($admin);

        return $this->render('booking/reservation.html.twig', [
            'reservations' => $reservations
        ]);
    }

    #[Route('/reservation/create', name: 'app_booking_create')]
    public function create(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $admin = $security->getUser();
        
        if (!$admin) {
            return $this->redirectToRoute('app_login');
        }

        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservation->setAdmin($admin);
            $entityManager->persist($reservation);
            $entityManager->flush();

            $this->addFlash('success', 'Réservation créée avec succès.');
            return $this->redirectToRoute('app_booking');
        }

        return $this->render('booking/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/reservation/edit/{id}', name: 'app_reservation_edit')]
    public function edit(Reservation $reservation, Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $admin = $security->getUser();
        
        if (!$admin || $reservation->getAdmin() !== $admin) {
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Réservation modifiée avec succès.');
            return $this->redirectToRoute('app_booking');
        }

        return $this->render('booking/edit.html.twig', [
            'form' => $form->createView(),
            'reservation' => $reservation
        ]);
    }

    #[Route('/reservation/delete/{id}', name: 'app_reservation_delete')]
    public function delete(Reservation $reservation, EntityManagerInterface $entityManager, Security $security): Response
    {
        $admin = $security->getUser();
        
        if (!$admin || $reservation->getAdmin() !== $admin) {
            return $this->redirectToRoute('app_login');
        }

        $entityManager->remove($reservation);
        $entityManager->flush();

        $this->addFlash('success', 'Réservation supprimée avec succès.');
        return $this->redirectToRoute('app_booking');
    }
}
