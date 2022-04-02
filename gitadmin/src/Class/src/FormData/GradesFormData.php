<?php

declare(strict_types=1);

namespace Frontend\Classs\FormData;

use Frontend\Classs\Entity\Year;
use Frontend\Classs\Entity\Grades;
use Frontend\Classs\Entity\Classs;
use Frontend\Classs\Entity\ClasssInterface;
use Frontend\Classs\Entity\GradesInterface;
use Frontend\Classs\Service\ClassService;
use Frontend\Classs\Service\GradesService;
use Frontend\User\Service\UserService;
use Frontend\User\Entity\User;
use Frontend\User\Entity\UserRole;

/**
 * Class GradesFormData
 * @package Frontend\Classs\FormData
 */
class GradesFormData
{
    public ?string $users = null;

    /**
     * @return array
     */
    public function getFormUsers(): array
    {
        return $this->users;
    }

    /**
     * @param Grades|object $grades
     */
    public function fromEntity(Grades $grades)
    {
        // /** @var Grades $grades */
        // foreach ($grades->get() as $grade) {
        // $this->users[] = $grade->getStudentId()->toString();
        // }
        $this->users = $user->getIdentity()->getUuid()->toString();
    }
}