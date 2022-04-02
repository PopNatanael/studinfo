<?php

namespace Frontend\Classs\Service;

use Frontend\Classs\Entity\Classs;
use Frontend\Classs\Entity\Grades;
use Frontend\Classs\Entity\Year;
use Frontend\Classs\Repository\YearRepository;
use Doctrine\ORM\EntityNotFoundException;

/**
 * Class YearService
 * @package Frontend\Classs\Service
 */
interface YearServiceInterface
{
    /**
     * @return YearRepository
     */
    public function getRepository(): YearRepository;
}
