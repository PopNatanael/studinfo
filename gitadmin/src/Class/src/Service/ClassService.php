<?php

declare(strict_types=1);

namespace Frontend\Classs\Service;

use Frontend\Classs\Entity\Classs;
use Frontend\Classs\Entity\Grades;
use Frontend\Classs\Entity\Year;
use Dot\AnnotatedServices\Annotation\Inject;
use Dot\AnnotatedServices\Annotation\Service;
use Frontend\Classs\Repository\ClassRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;
use Dot\Mail\Exception\MailException;
use Dot\Mail\Service\MailService;
use Mezzio\Template\TemplateRendererInterface;

/**
 * Class ClassService
 * @package Frontend\Classs\Service
 * @Service()
 */
class ClassService implements ClassServiceInterface
{
    /** @var ClassRepository $repository */
    protected $repository;

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
     * @Inject({EntityManager::class, MailService::class, TemplateRendererInterface::class, "config"})
     */
    public function __construct(
        EntityManager $entityManager,
        MailService $mailService,
        TemplateRendererInterface $templateRenderer,
        array $config = []
    ) {
        $this->repository = $entityManager->getRepository(Classs::class);
        $this->mailService = $mailService;
        $this->templateRenderer = $templateRenderer;
        $this->config = $config;
    }

    /**
     * @return ClassRepository
     */
    public function getRepository(): ClassRepository
    {
        return $this->repository;
    }

    /**
     * @param array $data
     */
    public function processClass(array $data)
    {
        /** @var Classs $class */
        $class = new Classs(
            $data['name'],
            $data['year'],
        );

        return $this->getRepository()->saveClass($class);
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
    public function getClasses(
        int $offset = 0,
        int $limit = 30,
        string $search = null,
        string $sort = 'created',
        string $order = 'desc')
        {
            $result = [
                'rows' => [],
                'total' => $this->getRepository()->countClasses($search)
            ];
            $classes = $this->getRepository()->getClasses($offset, $limit, $search, $sort, $order);
    
            /** @var Classs $class */
            foreach ($classes as $class) {
    
                $result['rows'][] = [
                    'uuid' => $class->getUuid()->toString(),
                    'name' => $class->getName(),
                    'status' => $class->getStatus(),
                    'created' => $class->getCreated()->format("Y-m-d")
                ];
            }
    
            return $result;
        }
}
