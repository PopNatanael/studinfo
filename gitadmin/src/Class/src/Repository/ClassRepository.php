<?php

declare(strict_types=1);

namespace Frontend\Classs\Repository;

use Frontend\Classs\Entity\Classs;
use Frontend\Classs\Entity\Grades;
use Frontend\Classs\Entity\Year;
use Doctrine\ORM;
use Doctrine\ORM\EntityRepository;

/**
 * Class ClassRepository
 * @package Frontend\Classs\Repository
 */
class ClassRepository extends EntityRepository
{
    /**
     * @param Classs $class
     * @throws ORM\ORMException
     * @throws ORM\OptimisticLockException
     */
    public function saveClass(Classs $class)
    {
        $this->getEntityManager()->persist($class);
        $this->getEntityManager()->flush();
    }

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
     * @param string|null $search
     * @return int|mixed|string
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countClasses(string $search = null)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('count(class)')->from(Classs::class, 'class');

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
    public function getClasses(
    int $offset = 0,
    int $limit = 30,
    string $search = null,
    string $sort = 'created',
    string $order = 'desc')
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('class')
            ->from(Classs::Class, 'class');
        $qb->setFirstResult($offset)->setMaxResults($limit);

        return $qb->getQuery()->useQueryCache(true)->getResult();
    }

    /**
     * @param string $uuid
     * @return Classs|null
     * @throws NonUniqueResultException
     */
    public function getClass(string $uuid): ?Classs
    {
        return $this->find($uuid);
    }

    /**
     * @return array
     */
    public function getAllClasses(): array
    {
        return $this->findAll();
    }
}
