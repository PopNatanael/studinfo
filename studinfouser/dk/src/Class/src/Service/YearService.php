<?php

declare(strict_types=1);

namespace Frontend\Classs\Service;


use Frontend\Classs\Entity\Grades;
use Frontend\Classs\Entity\Year;
use Frontend\Classs\Repository\YearRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;
use Dot\AnnotatedServices\Annotation\Inject;
use Dot\AnnotatedServices\Annotation\Service;
use Dot\Mail\Exception\MailException;
use Dot\Mail\Service\MailService;
use Mezzio\Template\TemplateRendererInterface;

/**
 * Class YearService
 * @package Frontend\Classs\Service
 * @Service()
 */
class YearService implements YearServiceInterface
{
    /** @var YearRepository $repository */
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
        $this->repository = $entityManager->getRepository(Year::class);
        $this->mailService = $mailService;
        $this->templateRenderer = $templateRenderer;
        $this->config = $config;
    }

    /**
     * @return YearRepository
     */
    public function getRepository(): YearRepository
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
    public function getYears(
        int $offset = 0,
        int $limit = 30,
        string $search = null,
        string $sort = 'created',
        string $order = 'desc'
        )
        {
            $result = [
                'rows' => [],
                'total' => $this->getRepository()->countYears($search)
            ];
            $years = $this->getRepository()->getYears($offset, $limit, $search, $sort, $order);

            return $years;
        }
}
