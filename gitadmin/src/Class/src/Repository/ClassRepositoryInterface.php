<?php

declare(strict_types=1);

namespace Frontend\Classs\Repository;

use Frontend\Classs\Entity\Classs;
use Frontend\Classs\Entity\Grades;
use Frontend\Classs\Entity\Year;
use Doctrine\ORM;

/**
 * Class MessageRepositoryInterface
 * @package Frontend\Contact\Repository
 */
interface ClassRepositoryInterface
{
    /**
     * @param Classs $class
     * @throws ORM\ORMException
     * @throws ORM\OptimisticLockException
     */
    public function saveClass(Classs $class);

    /**
     * @param Year $year
     * @throws ORM\ORMException
     * @throws ORM\OptimisticLockException
     */
    public function saveYear(Year $year);
}
