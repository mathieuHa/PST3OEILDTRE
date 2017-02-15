<?php

namespace DTRE\OeilBundle\Repository;
use DateInterval;


/**
 * DailyDataRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DailyDataRepository extends \Doctrine\ORM\EntityRepository
{
    public function getDataDay(\Datetime $date)
    {
        $dateDay= new \DateTime($date->format("Y-m-d"));
        $qb = $this->createQueryBuilder("d");

        $qb->select('d')
            ->where('d.date = :date')
            ->setParameter('date', $dateDay);

        return $qb->getQuery()
            ->getOneOrNullResult();
    }

    public function getByWeek($id, \Datetime $date)
    {
        $from = new \DateTime($date->format("Y-m-d")." 00:00:00");
        $to   = new \DateTime($date->format("Y-m-d")." 00:00:00");
        $interval = new DateInterval('P0Y0M7DT0H0M0S'); //1min
        $to->add($interval);

        $qb = $this->createQueryBuilder("d");
        $qb
            ->join('d.sensor', 's')
            ->where('s.id = :id')
            ->andWhere('d.date BETWEEN :from AND :to')
            ->setParameter('from', $from )
            ->setParameter('to', $to)
            ->setParameter('id', $id)
        ;
        $result = $qb->getQuery()->getResult();

        return $result;
    }

    public function getByMonth($id, \Datetime $date)
    {
        $from = new \DateTime($date->format("Y-m")." 00:00:00");
        $to   = new \DateTime($date->format("Y-m")." 00:00:00");
        $interval = new DateInterval('P0Y1M0DT0H0M0S'); //1min
        $to->add($interval);

        $qb = $this->createQueryBuilder("d");
        $qb
            ->join('d.sensor', 's')
            ->where('s.id = :id')
            ->andWhere('d.date BETWEEN :from AND :to')
            ->setParameter('from', $from )
            ->setParameter('to', $to)
            ->setParameter('id', $id)
        ;
        $result = $qb->getQuery()->getResult();

        return $result;
    }

    public function getBySemester($id, \Datetime $date)
    {
        $from = new \DateTime($date->format("Y-m")." 00:00:00");
        $to   = new \DateTime($date->format("Y-m")." 00:00:00");
        $interval = new DateInterval('P0Y6M0DT0H0M0S'); //1min
        $to->add($interval);

        $qb = $this->createQueryBuilder("d");
        $qb
            ->join('d.sensor', 's')
            ->where('s.id = :id')
            ->andWhere('d.date BETWEEN :from AND :to')
            ->setParameter('from', $from )
            ->setParameter('to', $to)
            ->setParameter('id', $id)
        ;
        $result = $qb->getQuery()->getResult();

        return $result;
    }

    public function getByYear($id, \Datetime $date)
    {
        $from = new \DateTime($date->format("Y")." 00:00:00");
        $to   = new \DateTime($date->format("Y")." 00:00:00");
        $interval = new DateInterval('P1YM0DT0H0M0S'); //1min
        $to->add($interval);

        $qb = $this->createQueryBuilder("d");
        $qb
            ->join('d.sensor', 's')
            ->where('s.id = :id')
            ->andWhere('d.date BETWEEN :from AND :to')
            ->setParameter('from', $from )
            ->setParameter('to', $to)
            ->setParameter('id', $id)
        ;
        $result = $qb->getQuery()->getResult();

        return $result;
    }
}
