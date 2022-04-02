<?php

declare(strict_types=1);

namespace Frontend\Classs\Repository;

use Frontend\Classs\Entity\Classs;
use Frontend\Classs\Entity\Grades;
use Frontend\Classs\Entity\Year;
use Frontend\User\Entity\User;
use Frontend\User\Entity\Admin;
use Frontend\User\Entity\AdminInterface;
use Doctrine\ORM;
use Doctrine\ORM\EntityRepository;
use Frontend\App\Repository\AbstractRepository;

/**
 * Class GradesRepository
 * @package Frontend\Classs\Repository
 */
class GradesRepository extends AbstractRepository
{
    /**
     * @param int $offset
     * @param int $limit
     * @param string|null $search
     * @param string $sort
     * @param string $order
     * @return int|mixed|string
     */
    public function getGrades(
        int $offset = 0,
        int $limit = 30,
        string $search = null,
        string $sort = 'created',
        string $order = 'desc'
    ) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('grades')
            ->from(Grades::class, 'grades')
            ->join("grades.studentId", "user")
            ->where("user.isDeleted != 1");

        $qb->setFirstResult($offset)->setMaxResults($limit)->orderBy('grades.' . $sort, $order);

        if(!is_null($search)) {
            $qb->where($qb->expr()->like('user.identity', ':search'))
                ->setParameter('search', '%' . $search . '%')
                ->andWhere("user.isDeleted != 1");
        }
        $qb->setFirstResult($offset)->setMaxResults($limit)->orderBy('user.' . $sort, $order);

        return $qb->getQuery()->useQueryCache(true)->getResult();
    }

    /**
     * @param string|null $search
     * @return int|mixed|string
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countGrades(string $search = null)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('count(grades)')->from(Grades::class, 'grades')->join('grades.studentId', 'user')->where("user.isDeleted != 1");
        if(!is_null($search)) {
            $qb->where($qb->expr()->like('user.identity', ':search'))
                ->setParameter('search', '%' . $search . '%')
                ->andWhere("user.isDeleted != 1");
        }

        return $qb->getQuery()->useQueryCache(true)->getSingleScalarResult();
    }

    /**
     * @param Grades $grade
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function saveGrade(Grades $grade)
    {
        $this->getEntityManager()->persist($grade);
        $this->getEntityManager()->flush();
    }

    /**
     * @param string $uuid
     * @return User|null
     * @throws NonUniqueResultException
     */
    public function findUserByUuid(string $uuid): ?User
    {
        $qb = $this->getQueryBuilder();

        $qb
            ->select('user')
            ->from(User::class, 'user')
            ->andWhere('user.uuid = :uuid')
            ->setParameter('uuid', $uuid);

        return $qb->getQuery()->useQueryCache(true)->getOneOrNullResult();
    }
}
