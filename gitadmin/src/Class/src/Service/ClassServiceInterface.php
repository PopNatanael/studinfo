<?php

namespace Frontend\Classs\Service;

use Frontend\Classs\Entity\Classs;
use Frontend\Classs\Entity\Grades;
use Frontend\Classs\Entity\Year;
use Frontend\Classs\Repository\ClassRepository;
use Doctrine\ORM\EntityNotFoundException;

/**
 * Class MessageService
 * @package Frontend\Classs\Service
 */
interface ClassServiceInterface
{
    /**
     * @return ClassRepository
     */
    public function getRepository(): ClassRepository;
    public function processClass(array $data);
}
