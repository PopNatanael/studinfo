<?php

declare(strict_types=1);

namespace Frontend\User\Service;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Dot\AnnotatedServices\Annotation\Inject;
use Dot\AnnotatedServices\Annotation\Service;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Exception;
use Frontend\User\Entity\AdminRole;
use Frontend\User\Entity\User;
use Frontend\Classs\Entity\Classs;
use Frontend\Classs\Entity\Year;
use Frontend\Classs\Service\ClassService;
use Frontend\Classs\Service\YearService;
use Frontend\Classs\Repository\ClassRepository;
use Frontend\Classs\Repository\YearRepository;
use Frontend\Classs\Entity\GradesInterface;
use Frontend\Classs\Entity\Grades;
use Frontend\Classs\Repository\GradesRepository;
use Frontend\User\Entity\UserDetail;
use Frontend\User\Entity\UserInterface;
use Frontend\User\Entity\UserRole;
use Frontend\User\FormData\UserFormData;
use Frontend\User\FormData\AddGradeFormData;
use Frontend\User\Repository\UserRepository;
use Frontend\User\Repository\AdminRoleRepository;
use Mezzio\Template\TemplateRendererInterface;

/**
 * Class UserService
 * @package Frontend\Admin\Service
 *
 * @Service()
 */
class UserService implements UserServiceInterface
{
    public const EXTENSIONS = [
        'image/jpg' => 'jpg',
        'image/jpeg' => 'jpg',
        'image/png' => 'png'
    ];

    protected EntityManager $em;

    protected ClassRepository $classRepository;

    protected YearRepository $yearRepository;

    protected UserRepository $userRepository;

    protected UserRoleServiceInterface $userRoleService;
    
    protected ClassService $classService;

    protected YearService $yearService;

    protected AdminRoleRepository $adminRoleRepository;

    protected TemplateRendererInterface $templateRenderer;

    protected array $config = [];

    /**
     * UserService constructor.
     * @param EntityManager $em
     * @param UserRoleServiceInterface $userRoleService
     * @param ClassService $classService
     * @param YearService $yearService
     * @param TemplateRendererInterface $templateRenderer
     * @param array $config
     *
     * @Inject({EntityManager::class, UserRoleServiceInterface::class, ClassService::class, YearService::class, TemplateRendererInterface::class, "config"})
     */
    public function __construct(
        EntityManager $em,
        UserRoleServiceInterface $userRoleService,
        ClassService $classService,
        YearService $yearService,
        TemplateRendererInterface $templateRenderer,
        array $config = []
    ) {
        $this->em = $em;
        $this->adminRoleRepository = $em->getRepository(AdminRole::class);
        $this->userRepository = $em->getRepository(User::class);
        $this->gradesRepository = $em->getRepository(Grades::class);
        $this->classRepository = $em->getRepository(Classs::class);
        $this->yearRepository = $em->getRepository(Year::class);
        $this->userRoleService = $userRoleService;
        $this->classService = $classService;
        $this->yearService = $yearService;
        $this->templateRenderer = $templateRenderer;
        $this->config = $config;
    }

    /**
     * @return UserRepository
     */
    public function getUserRepository(): UserRepository
    {
        return $this->userRepository;
    }

    /**
     * @param User $user
     * @param UserFormData|object $data
     * @return UserInterface
     * @throws ORMException
     * @throws NonUniqueResultException
     * @throws OptimisticLockException
     * @throws Exception
     */
    public function addGrade(User $user, AddGradeFormData $data): GradesInterface
    {
        $grade = new Grades();
        if(!empty($data->identity)) {
            $grade->setUser($user);
        }
        if (!empty($data->classes)) {
            $class = $this->classService->getRepository()->getClass($data->classes);
            if (!$class instanceof Classs) {
                throw new Exception('Class with uuid : ' . $classUuid . ' not found!');
            }
            $grade->addClass($class);
        }
        if(!empty($data->grade)) {
            $grade->setGrade($data->grade);
        }
        if($user->getYear()->getUuid()->toString() == $class->getYear()->getUuid()->toString()) {
            /** @var Class $classes */
            foreach($user->getClasses() as $classes) {
                if(in_array($class, $user->getClasses())) {
                    $this->gradesRepository->saveGrade($grade);
                    break;
                }
                else {
                    throw new Exception("User must be enroled in class");
                }
            }
        }
        else {
            throw new Exception("Class must be from user year");
        }

        return $grade;
    }

    /**
     * @param UserFormData|object $data
     * @return UserInterface
     * @throws ORMException
     * @throws NonUniqueResultException
     * @throws OptimisticLockException
     * @throws Exception
     */
    public function createUser(UserFormData $data): UserInterface
    {
        if ($this->exists($data->identity)) {
            throw new ORMException('An account with this identity already exists.');
        }

        $user = new User();
        $user->setPassword(password_hash($data->password, PASSWORD_DEFAULT))->setIdentity($data->identity);

        $detail = new UserDetail();
        $detail->setUser($user)->setFirstName($data->firstName)->setLastName($data->lastName);

        $user->setDetail($detail);

        if (!empty($data->status)) {
            $user->setStatus($data->status);
        }

        if (!empty($data->year)) {
            $year = $this->userRoleService->getYearRepository()->findOneBy(['uuid' => $data->year]);
            if($year->getStatus() == User::STATUS_ACTIVE) {
                $user->setYear($year);
            }
            else {
                throw new Exception('Year must be active.');
            }
        }

        if (!empty($data->roles)) {
            foreach ($data->roles as $roleUuid) {
                $role = $this->userRoleService->getUserRoleRepository()->getRole($roleUuid);
                if (!$role instanceof UserRole) {
                    throw new Exception('Role with uuid : ' . $roleUuid . ' not found!');
                }
                $user->addRole($role);
            }
        } else {
            $role = $this->userRoleService->getUserRoleRepository()->findOneBy(['name' => UserRole::ROLE_USER]);
            if ($role instanceof UserRole) {
                $user->addRole($role);
            }
        }

        if (empty($user->getRoles())) {
            throw new Exception('User account must have at least one role');
        }

        if (!empty($data->classes)) {
            foreach ($data->classes as $classUuid) {
                $class = $this->classService->getRepository()->getClass($classUuid);
                if (!$class instanceof Classs) {
                    throw new Exception('Class with uuid : ' . $classUuid . ' not found!');
                }
                if($user->getYear()->getUuid()->toString() == $class->getYear()->getUuid()->toString()  && $class->getStatus() == User::STATUS_ACTIVE) {
                    $user->addClass($class);
                }
                else {
                    throw new Exception('Classes must be from student year.');
                }
            }
        }

        $this->userRepository->saveUser($user);

        return $user;
    }

    /**
     * @param User $user
     * @param UserFormData $data
     * @return User
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws Exception
     */
    public function updateUser(User $user, UserFormData $data): User
    {
        if (!empty($data->identity)) {
            if ($this->exists($data->identity) && $data->identity !== $user->getIdentity()) {
                throw new ORMException('An account with this identity already exists.');
            }
            $user->setIdentity($data->identity);
        }

        if (!empty($data->password)) {
            $user->setPassword(
                password_hash($data->password, PASSWORD_DEFAULT)
            );
        }

        if (!empty($data->year)) {
            $year = $this->userRoleService->getYearRepository()->findOneBy(['uuid' => $data->year]);
            if($year->getStatus() == User::STATUS_ACTIVE) {
                $user->setYear($year);
            }
            else {
                throw new Exception('Year must be active.');
            }
        }

        if (!empty($data->status)) {
            $user->setStatus($data->status);
        }

        if (!empty($data->firstName)) {
            $user->getDetail()->setFirstName($data->firstName);
        }

        if (!empty($data->lastName)) {
            $user->getDetail()->setLastName($data->lastName);
        }


        if (!empty($data->roles)) {
            $user->resetRoles();
            foreach ($data->roles as $roleUuid) {
                $role = $this->userRoleService->getUserRoleRepository()->findOneBy(['uuid' => $roleUuid]);
                if ($role instanceof UserRole) {
                    $user->addRole($role);
                }
            }
        }

        if (empty($user->getRoles())) {
            throw new Exception('User accounts must have at least one role.');
        }

        if (!empty($data->classes)) {
            $user->resetClasses();
            foreach ($data->classes as $classUuid) {
                $class = $this->classService->getRepository()->findOneBy(['uuid' => $classUuid]);
                if ($class instanceof Classs) {
                    if($user->getYear()->getUuid()->toString() == $class->getYear()->getUuid()->toString() && $class->getStatus() == User::STATUS_ACTIVE) {
                        $user->addClass($class);
                    }
                    else {
                        throw new Exception('Classes must be from student year.');
                    }
                }
            }
        }

        $this->userRepository->saveUser($user);

        return $user;
    }

    /**
     * @param string $identity
     * @return bool
     */
    public function exists(string $identity = ''): bool
    {
        return !is_null(
            $this->userRepository->exists($identity)
        );
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string|null $search
     * @param string $sort
     * @param string $order
     * @return array
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getUsers(
        int $offset = 0,
        int $limit = 30,
        string $search = null,
        string $sort = 'created',
        string $order = 'desc'
    ): array {
        $result = [
            'rows' => [],
            'total' => $this->getUserRepository()->countUsers($search)
        ];
        $users = $this->getUserRepository()->getUsers($offset, $limit, $search, $sort, $order);

        /** @var User $user */
        foreach ($users as $user) {
            if($user->getIsDeleted() !== User::IS_DELETED_YES) {
            $roles = [];
            /** @var UserRole $role */
            foreach ($user->getRoles() as $role) {
                $roles[] = $role->getName();
            }
            $classes = [];
            /** @var Classs $class */
            foreach($user->getClasses() as $class) {
                $classes[] = $class->getName();
            }
            if($user->getYear() == null) {
                $result['rows'][] = [
                    'uuid' => $user->getUuid()->toString(),
                    'identity' => $user->getIdentity(),
                    'firstName' => $user->getDetail()->getFirstName(),
                    'lastName' => $user->getDetail()->getLastname(),
                    'roles' => implode(", ", $roles),
                    'classes' => implode(", ", $classes),
                    'year' => $user->getYear(),
                    'isDeleted' => $user->getIsDeleted(),
                    'status' => $user->getStatus(),
                    'created' => $user->getCreated()->format("Y-m-d")
                ];
            }
            else {
                $result['rows'][] = [
                    'uuid' => $user->getUuid()->toString(),
                    'identity' => $user->getIdentity(),
                    'firstName' => $user->getDetail()->getFirstName(),
                    'lastName' => $user->getDetail()->getLastname(),
                    'roles' => implode(", ", $roles),
                    'classes' => implode(", ", $classes),
                    'year' => $user->getYear()->getYear(),
                    'isDeleted' => $user->getIsDeleted(),
                    'status' => $user->getStatus(),
                    'created' => $user->getCreated()->format("Y-m-d")
                ];
            }
            
            }
        }

        return $result;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string|null $search
     * @param string $sort
     * @param string $order
     * @return array
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getUserYear(
        int $offset = 0,
        int $limit = 30,
        string $search = null,
        string $sort = 'created',
        string $order = 'desc'
    ): array {
        $users = $this->getUserRepository()->getUsers($offset, $limit, $search, $sort, $order);
        /** @var User $user */
        foreach ($users as $user) {

            $result [] = [
                'year' => $user->getYear()
            ];
        }
        return $result;
    }

    /**
     * @param array $params
     * @return User|null
     */
    public function findOneBy(array $params = []): ?User
    {
        if (empty($params)) {
            return null;
        }

        return $this->userRepository->findOneBy($params);
    }

    /**
     * @param string $email
     * @return array
     * @throws NonUniqueResultException
     */
    public function getRoleNamesByEmail(string $email): array
    {
        $roleList = [];

        /** @var User $user */
        $user = $this->userRepository->getUserByEmail($email);

        if (!empty($user)) {
            /** @var UserRole $role */
            foreach ($user->getRoles() as $role) {
                $roleList[] = $role->getName();
            }
        }

        return $roleList;
    }

    /**
     * @return array
     */
    public function getAdminFormProcessedRoles(): array
    {
        $roles = [];
        $result = $this->adminRoleRepository->getRoles();

        if (!empty($result)) {
            /** @var AdminRole $role */
            foreach ($result as $role) {
                $roles[$role->getUuid()->toString()] = $role->getName();
            }
        }

        return $roles;
    }

    /**
     * @return array
     */
    public function getUserFormProcessedRoles(): array
    {
        $roles = [];
        $result = $this->userRoleService->getUserRoleRepository()->getRoles();

        if (!empty($result)) {
            /** @var UserRole $role */
            foreach ($result as $role) {
                $roles[$role->getUuid()->toString()] = $role->getName();
            }
        }

        return $roles;
    }

    /**
     * @return array
     */
    public function getUserFormProcessedClasses(): array
    {
        $users = $this->getUserYear();
        $classes = [];
        $result = $this->classService->getRepository()->getAllClasses();
        if (!empty($result)) {
            /** @var Classs $class */
            foreach ($result as $class) {
                // if($class->getYear()->getYear() == '2')
                $classes[$class->getUuid()->toString()] = $class->getName().'('.$class->getYear()->getYear().')';
            }
        }
        return $classes;
    }

    /**
     * @return array
     */
    public function getUserFormYears(): array
    {
        $years = [];
        $result = $this->userRoleService->getYearRepository()->getAllYears();

        if (!empty($result)) {
            /** @var Year $year */
            foreach ($result as $year) {
                $years[$year->getUuid()->toString()] = $year->getYear();
            }
        }

        return $years;
    }
}
