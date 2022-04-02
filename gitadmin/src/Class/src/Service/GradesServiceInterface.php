<?php

namespace Frontend\Classs\Service;

use Frontend\Classs\Entity\Classs;
use Frontend\Classs\Entity\Grades;
use Frontend\Classs\Entity\Year;
use Frontend\Classs\Repository\GradesRepository;
use Doctrine\ORM\EntityNotFoundException;

/**
 * Class GradesService
 * @package Frontend\Classs\Service
 */
interface GradesServiceInterface
{
    /**
     * @return GradesRepository
     */
    public function getGradesRepository(): GradesRepository;
}
