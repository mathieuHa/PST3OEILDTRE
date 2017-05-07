<?php
/**
 * Created by PhpStorm.
 * User: kafim
 * Date: 06/05/2017
 * Time: 21:54
 */

namespace DTRE\OeilBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

class AbstractRepository extends EntityRepository
{
    protected function paginate(QueryBuilder $qb, $limit = 20, $offset = 0)
    {
        if (0 == $limit || 0 == $offset) {
            throw new \LogicException('$limit & $offstet must be greater than 0.');
        }

        $pager = new Pagerfanta(new DoctrineORMAdapter($qb));
        $pager->setCurrentPage(ceil($offset + 1) / $limit);
        $pager->setMaxPerPage((int) $limit);

        return $pager;
    }
}