<?php

declare(strict_types=1);

namespace Frontend\Classs\Repository;

use Frontend\Classs\Entity\Classs;
use Frontend\Classs\Entity\Grades;
use Frontend\Classs\Entity\Year;
use Doctrine\ORM;
use Doctrine\ORM\EntityRepository;

/**
 * Class YearRepository
 * @package Frontend\Classs\Repository
 */
class YearRepository extends EntityRepository
{
    /**
     * @param Year $year
     * @throws ORM\ORMException
     * @throws ORM\OptimisticLockException
     */
    public function saveYear(Year $year)
    {
        $this->getEntityManager()->persist($year);
        $this->getEntityManager()->flush();
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
    ) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('year')
            ->from(Year::class, 'year');

        $qb->setFirstResult($offset)->setMaxResults($limit)->orderBy('year.' . $sort, $order);

        return $qb->getQuery()->useQueryCache(true)->getResult();
    }

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
     * @return array
     */
    public function getAllYears(): array
    {
        return $this->findAll();
    }
}
