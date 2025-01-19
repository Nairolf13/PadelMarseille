<?php

namespace App\Repository;

use App\Entity\Admin;
use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservation>
 *
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    /**
     * Find future reservations for a specific admin
     *
     * @param Admin $admin
     * @return Reservation[]
     */
    public function findFutureReservations(Admin $admin)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.admin = :admin')
            ->andWhere('r.date >= :today')
            ->setParameter('admin', $admin)
            ->setParameter('today', new \DateTime('today'))
            ->orderBy('r.date', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Check if a reservation already exists for the same court, date, and time
     */
    public function isCourtAvailable(\DateTimeInterface $date, string $time, int $court)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.date = :date')
            ->andWhere('r.time = :time')
            ->andWhere('r.court = :court')
            ->setParameter('date', $date)
            ->setParameter('time', $time)
            ->setParameter('court', $court)
            ->getQuery()
            ->getOneOrNullResult() === null;
    }

    /**
     * Find reservations for a specific court
     */
    public function findByCourt(int $court)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.court = :court')
            ->setParameter('court', $court)
            ->orderBy('r.date', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find reservations between two dates
     */
    public function findBetweenDates(\DateTimeInterface $startDate, \DateTimeInterface $endDate)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.date BETWEEN :start AND :end')
            ->setParameter('start', $startDate)
            ->setParameter('end', $endDate)
            ->orderBy('r.date', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
