<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(ReservationRepository $reservationRepository, Security $security): Response
    {
        $admin = $security->getUser();
        
        if (!$admin) {
            return $this->redirectToRoute('app_login');
        }

        $futureReservations = $reservationRepository->findFutureReservations($admin);
        $totalReservations = count($futureReservations);
        
        // Calculer des statistiques sur les réservations
        $courtUsage = [1 => 0, 2 => 0, 3 => 0];
        foreach ($futureReservations as $reservation) {
            $courtUsage[$reservation->getCourt()]++;
        }

        return $this->render('dashboard/index.html.twig', [
            'futureReservations' => $futureReservations,
            'totalReservations' => $totalReservations,
            'courtUsage' => $courtUsage
        ]);
    }
}
