<?php

declare(strict_types=1);

namespace Frontend\Classs\Repository;

use Frontend\Classs\Entity\Classs;
use Frontend\Classs\Entity\Grades;
use Frontend\Classs\Entity\Year;
use Doctrine\ORM;

/**
 * Class YearRepositoryInterface
 * @package Frontend\Contact\Repository
 */
interface YearRepositoryInterface
{
    /**
     * @param Year $year
     * @throws ORM\ORMException
     * @throws ORM\OptimisticLockException
     */
    public function saveYear(Year $year);
}
