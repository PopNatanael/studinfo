<?php

declare(strict_types=1);

namespace Frontend\Classs\Repository;

use Frontend\Classs\Entity\Classs;
use Frontend\Classs\Entity\Grades;
use Frontend\Classs\Entity\Year;
use Doctrine\ORM;

/**
 * Class GradesRepositoryInterface
 * @package Frontend\Contact\Repository
 */
interface GradesRepositoryInterface
{
    /**
     * @param Grades $grade
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function saveGrade(Grades $grade);
}
