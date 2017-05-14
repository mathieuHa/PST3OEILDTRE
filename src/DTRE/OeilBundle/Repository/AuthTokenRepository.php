<?php
/**
 * Created by PhpStorm.
 * User: kafim
 * Date: 06/05/2017
 * Time: 21:54
 */

namespace DTRE\OeilBundle\Repository;


use Doctrine\ORM\EntityRepository;

class AuthTokenRepository extends EntityRepository
{
    public function getToken($token)
    {
        $qb = $this->createQueryBuilder("t");
        $qb
            ->where('t.value = :value')
            ->setParameter('value', $token)
        ;
        $result = $qb->getQuery()->getOneOrNullResult();

        return $result;
    }
}