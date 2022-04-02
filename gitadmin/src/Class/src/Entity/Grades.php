<?php

/**
 * @see https://github.com/dotkernel/frontend/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/frontend/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace Frontend\Classs\Entity;

use Frontend\App\Entity\AbstractEntity;
use Doctrine\ORM\EntityRepository;
use Frontend\Classs\Entity\GradesInterface;
use Frontend\Classs\Entity\Classs;
use Frontend\User\Entity\User;
use Frontend\Classs\Entity\ClasssInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Grades
 * @package Frontend\Frontend\Classs\Entity
 *
 * @ORM\Entity(repositoryClass="Frontend\Classs\Repository\GradesRepository")
 * @ORM\Table(name="grade")
 * @ORM\HasLifecycleCallbacks
 * @package Frontend\Classs\Entity
 */
class Grades extends AbstractEntity implements GradesInterface
{
    public const PLATFORM_WEBSITE = 'website';
    public const PLATFORM_ADMIN = 'admin';

    /**
     * @ORM\OneToOne(targetEntity="Frontend\User\Entity\User")
     * @ORM\JoinColumn(name="studentId", referencedColumnName="uuid", nullable=false)
     * @var User
     */
    protected $studentId;

    /**
     * @ORM\OneToOne(targetEntity="Frontend\Classs\Entity\Classs")
     * @ORM\JoinColumn(name="classId", referencedColumnName="uuid", nullable=false)
     * @var Classs
     */
    protected $classId;

    /**
     * @ORM\Column(name="grade", type="integer")
     * @var integer
     */
    protected $grade;

    /**
     * Grades constructor.
     * @param string $studentId
     * @param string $classId
     * @param string $grade
     */
    public function __construct() {
        parent::__construct();

    }

    /**
     * @return string
     */
    public function getStudentId()
    {
        return $this->studentId;
    }

    /**
     * @return string
     */
    public function getClassId()
    {
        return $this->classId;
    }

    /**
     * @return string
     */
    public function getGrade(): int
    {
        return $this->grade;
    }

    /**
     * @return string
     */
    public function getPlatform(): string
    {
        return $this->platform;
    }

    /**
     * @return mixed
     */
    public function getStudents()
    {
        return $this->studentId;
    }

    /**
     * @param string $platform
     */
    public function setPlatform(string $platform): void
    {
        $this->platform = $platform;
    }

    /**
     * @param User $user
     * @return User|null
     */
    public function setUser(User $user): ?User
    {
        $this->studentId = $user;

        return $this->studentId;
    }

    /**
     * @param string $newStudentId
     * @return string
     */
    public function setStudentId(string $newStudentId): string
    {
        $this->studentId = $newStudentId;

        return $this->studentId;
    }

    /**
     * @param string $newGrade
     * @return string
     */
    public function setGrade(string $newGrade): string
    {
        $this->grade = $newGrade;

        return $this->grade;
    }

     /**
     * @param Classs $class
     * @return ClasssInterface
     */
    public function addClass(Classs $class)
    {
        $this->classId = $class;

        return $this;
    }
}
