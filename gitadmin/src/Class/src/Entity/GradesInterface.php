<?php

declare(strict_types=1);
namespace Frontend\Classs\Entity;

use Frontend\Classs\Entity\Grades;
use Frontend\Classs\Entity\Classs;
use Frontend\User\Entity\User;

/**
 * Interface GradesInterface
 * @package Frontend\Classs\Entity
 */
interface GradesInterface
{
    public function setUser(User $user): ?User;
}
