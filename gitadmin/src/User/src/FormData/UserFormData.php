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
 * Class UserFormData
 * @package Frontend\User\FormData
 */
class UserFormData
{
    public ?string $identity = null;
    public ?string $firstName = null;
    public ?string $lastName = null;
    public ?string $status = null;
    public ?string $year = null;
    public array $classes = [];
    public array $roles = [];

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @return array
     */
    public function getClasses(): array
    {
        return $this->classes;
    }

    /**
     * @return array
     */
    public function getAllYears(): array
    {
        return $this->year;
    }

    /**
     * @param User|object $user
     */
    public function fromEntity(User $user)
    {
        /** @var UserRole $role */
        foreach ($user->getRoles() as $role) {
            $this->roles[] = $role->getUuid()->toString();
        }
        /** @var Classs $class */
        foreach ($user->getClasses() as $class) {
            $this->classes[] = $class->getUuid()->toString();
        }
        $this->firstName = $user->getDetail()->getFirstName();
        $this->lastName = $user->getDetail()->getLastName();
        $this->identity = $user->getIdentity();
        if($user->getYear() == null) {
            $this->year = null;
        }
        else {
            $this->year = $user->getYear()->getUuid()->toString();
        }
        $this->status = $user->getStatus();
    }

    /**
     * @return array
     */
    public function getArrayCopy()
    {
        return [
            'identity' => $this->identity,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'status' => $this->status,
            'year' => $this->year,
            'classes' => $this->classes,
            'roles' => $this->roles
        ];
    }
}
