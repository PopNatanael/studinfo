<?php

declare(strict_types=1);

namespace Frontend\Classs;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Dot\AnnotatedServices\Factory\AnnotatedServiceFactory;
use Frontend\Classs\Controller\ClassController;
use Frontend\Classs\Controller\GradesController;
use Frontend\Classs\Controller\YearController;
use Frontend\Contact\Form\ContactForm;
use Frontend\Classs\Service\ClassService;
use Frontend\Classs\Service\ClassServiceInterface;
use Frontend\Classs\Service\GradesService;
use Frontend\Classs\Service\GradesServiceInterface;
use Frontend\Classs\Service\YearService;
use Frontend\Classs\Service\YearServiceInterface;
use Laminas\Form\ElementFactory;
use Mezzio\Application;

/**
 * Class ConfigProvider
 * @package Frontend\Classs
 */
class ConfigProvider
{
    /**
     * @return array
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
            'dot_form' => $this->getForms(),
            'doctrine' => $this->getDoctrineConfig()
        ];
    }

    /**
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            'delegators' => [
                Application::class => [
                    RoutesDelegator::class,
                ],
            ],
            'factories'  => [
                ClassController::class => AnnotatedServiceFactory::class,
                GradesController::class => AnnotatedServiceFactory::class,
                YearController::class => AnnotatedServiceFactory::class,
                ClassService::class => AnnotatedServiceFactory::class,
                GradesService::class => AnnotatedServiceFactory::class,
                YearService::class => AnnotatedServiceFactory::class,
            ],
            'aliases' => [
                ClassServiceInterface::class => ClassService::class,
                GradesServiceInterface::class => GradesService::class,  
                YearServiceInterface::class => YearService::class,
            ]
        ];
    }

    /**
     * @return array
     */
    public function getTemplates(): array
    {
        return [
            'paths' => [
                'class' => [__DIR__ . '/../templates/class']
            ],
        ];
    }

    /**
     * @return array
     */
    public function getForms()
    {
        return [
            'form_manager' => [
                'factories' => [
                    ContactForm::class => ElementFactory::class,
                ],
                'aliases' => [
                ],
            ],
        ];
    }

    public function getDoctrineConfig()
    {
        return [
            'driver' => [
                'orm_default' => [
                    'drivers' => [
                        'Frontend\Classs\Entity' => 'ClassEntities',
                    ]
                ],
                'ClassEntities' => [
                    'class' => AnnotationDriver::class,
                    'cache' => 'array',
                    'paths' => [__DIR__ . '/Entity'],
                ]
            ]
        ];
    }
}
