<?php

declare(strict_types=1);

namespace Frontend\Classs\Service;

use Frontend\Classs\Entity\Classs;
use Frontend\Classs\Entity\Grades;
use Frontend\Classs\Entity\Year;
use Frontend\User\Entity\User;
use Frontend\Classs\Repository\GradesRepository;
use Frontend\User\Repository\UserRepository;
use Frontend\User\Service\UserService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;
use Dot\AnnotatedServices\Annotation\Inject;
use Dot\AnnotatedServices\Annotation\Service;
use Dot\Mail\Exception\MailException;
use Frontend\Classs\Entity\GradesInterface;
use Dot\Mail\Service\MailService;
use Mezzio\Template\TemplateRendererInterface;

/**
 * Class GradesService
 * @package Frontend\Classs\Service
 * @Service()
 */
class GradesService implements GradesServiceInterface
{
    /** @var GradesRepository $repository */
    protected $repository;

    /** @var UserRepository $userRepository */
    protected $userRepository;
    
    /** @var UserService $userService */
    protected $userService;

    /** @var MailService $mailService */
    protected $mailService;

    /** @var TemplateRendererInterface $templateRenderer */
    protected $templateRenderer;

    /** @var array $config */
    protected $config;

    /**
     * MessageService constructor.
     * @param EntityManager $entityManager
     * @param MailService $mailService
     * @param TemplateRendererInterface $templateRenderer
     * @param array $config
     *
     * @Inject({EntityManager::class, MailService::class, UserService::class, TemplateRendererInterface::class, "config"})
     */
    public function __construct(
        EntityManager $entityManager,
        MailService $mailService,
        UserService $userService,
        TemplateRendererInterface $templateRenderer,
        array $config = []
    ) {
        $this->repository = $entityManager->getRepository(Grades::class);
        $this->userRepository = $entityManager->getRepository(User::class);
        $this->mailService = $mailService;
        $this->userService = $userService;
        $this->templateRenderer = $templateRenderer;
        $this->config = $config;
    }

    /**
     * @return GradesRepository
     */
    public function getGradesRepository(): GradesRepository
    {
        return $this->repository;
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
    public function getAllGrades(
        int $offset = 0,
        int $limit = 30,
        string $search = null,
        string $sort = 'created',
        string $order = 'desc'
    ): array {
        $result = [
            'rows' => [],
            'total' => $this->getGradesRepository()->countGrades($search)
        ];
        $grades = $this->getGradesRepository()->getGrades($offset, $limit, $search, $sort, $order);

        /** @var Grades $grade */
        foreach ($grades as $grade) {
            $result['rows'][] = [
                'uuid' => $grade->getUuid()->toString(),
                'identity' => $grade->getStudentId()->getIdentity(),
                'grade' => $grade->getGrade(),
                'class' => $grade->getClassId()->getName(),
                'created' => $grade->getCreated()->format("Y-m-d")
            ];
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getGradesFormUsers(): array
    {
        $users = [];
        $result = $this->userService->getUserRepository()->getAllUsers();

        if (!empty($result)) {
            /** @var User $user */
            foreach ($result as $user) {
                $users[$user->getUuid()->toString()] = $user->getIdentity();
            }
        }

        return $users;
    }

    /**
     * @param GradesFormData|object $data
     * @return GradesInterface
     * @throws ORMException
     * @throws NonUniqueResultException
     * @throws OptimisticLockException
     * @throws Exception
     */
    public function createUser(GradesFormData $data): GradesInterface
    {
        if (!empty($data->users)) {
            $user = $this->userService->getUserRepository()->findOneBy(['uuid' => $data->users]);
            $user->setUser($user);
        }
    }
}
