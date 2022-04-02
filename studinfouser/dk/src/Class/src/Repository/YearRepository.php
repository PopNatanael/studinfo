<?php

declare(strict_types=1);

namespace Frontend\Classs\Repository;

use Frontend\Classs\Entity\Year;
use Frontend\User\Entity\User;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;
use Doctrine\ORM;
use Doctrine\ORM\EntityRepository;

/**
 * Class YearRepository
 * @package Frontend\Classs\Repository
 */
class YearRepository extends EntityRepository
{
     /**
     * @param string|null $search
     * @return int|mixed|string
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countYears(string $search = null)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('count(year)')->from(Year::class, 'year');

        return $qb->getQuery()->useQueryCache(true)->getSingleScalarResult();
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string|null $search
     * @param string $sort
     * @param string $order
     * @return int|mixed|string
     */
    public function getYears(
    int $offset = 0,
    int $limit = 30,
    string $search = null,
    string $sort = 'created',
    string $order = 'desc'
    )
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('year')
            ->from(Year::Class, 'year');
        $qb->setFirstResult($offset)->setMaxResults($limit);

        return $qb->getQuery()->useQueryCache(true)->getResult();
    }
}
