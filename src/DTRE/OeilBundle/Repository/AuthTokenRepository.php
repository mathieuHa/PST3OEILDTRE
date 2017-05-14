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
    public function getToken($id)
    {
        $qb = $this->createQueryBuilder("a");
        $qb
            ->where('a.user = :id')
            ->orderBy('a.createdAt', 'DESC')
            ->setParameter('id', $id)
        ;
        $result = $qb->getQuery()->getOneOrNullResult();

        return $result;
    }
}