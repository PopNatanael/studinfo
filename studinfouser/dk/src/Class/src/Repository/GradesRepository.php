<?php

declare(strict_types=1);

namespace Frontend\Classs\Repository;

use Frontend\Classs\Entity\Grades;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;
use Doctrine\ORM;
use Doctrine\ORM\EntityRepository;

/**
 * Class GradesRepository
 * @package Frontend\Classs\Repository
 */
class GradesRepository extends EntityRepository
{
     /**
     * @param string|null $search
     * @return int|mixed|string
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countGrades(string $search = null)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('count(grade)')->from(Grades::class, 'grade');

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
    public function getGrades(
    int $offset = 0,
    int $limit = 30,
    string $search = null,
    string $sort = 'created',
    string $order = 'desc',
    string $uuid
    )
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('grade')
            ->from(Grades::Class, 'grade')
            ->join("grade.classId", "class")
            ->where("grade.studentId = :uuid")
            ->setParameter('uuid', $uuid, UuidBinaryOrderedTimeType::NAME)
            ->andWhere("class.year = :yearUuid")
            ->setParameter('yearUuid', $search, UuidBinaryOrderedTimeType::NAME);

        return $qb->getQuery()->useQueryCache(true)->getResult();
    }
}
