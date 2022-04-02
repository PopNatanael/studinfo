<?php

declare(strict_types=1);

namespace Frontend\User\FormData;
use Frontend\Classs\Entity\Year;
use Frontend\Classs\Entity\Classs;
use Frontend\Classs\Entity\ClasssInterface;
use Frontend\Classs\Service\ClassService;
use Frontend\User\Entity\User;
use Frontend\User\Entity\UserRole;
use Frontend\User\Service\UserService;

/**
 * Class AddGradeFormData
 * @package Frontend\User\FormData
 */
class AddGradeFormData
{
    public ?string $identity = null;
    public ?string $classes = null;
    public ?string $grade = null;

     /**
     * @return array
     */
    public function getClasses(): array
    {
        return $this->classes;
    }

    /**
     * @param User|object $user
     */
    public function fromEntity(User $user)
    {
        /** @var UserRole $role */
        foreach ($user->getClasses() as $class) {
                $this->classes = $class->getUuid()->toString();
            }
        $this->identity = $user->getIdentity();
    }

     /**
     * @return array
     */
    public function getArrayCopy()
    {
        return [
            'identity' => $this->identity,
            'classes' => $this->classes
        ];
    }
}
