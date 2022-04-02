<?php

declare(strict_types=1);

namespace Frontend\Classs\Factory;

use Frontend\Classs\Form\GradesForm;
use Frontend\User\Service\UserService;
use Frontend\Classs\Entity\Classs;
use Frontend\Classs\Entity\Grades;
use Frontend\Classs\Entity\ClasssInterface;
use Frontend\Classs\Service\ClassService;
use Frontend\Classs\Service\GradesService;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class UserGradesDelegator
 * @package Frontend\Classs\Factory
 */
class UserGradesDelegator implements DelegatorFactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $name
     * @param callable $callback
     * @param array|null $options
     * @return UserForm|mixed|object
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $name, callable $callback, array $options = null)
    {
        $gradesForm = $callback();

        if ($gradesForm instanceof GradesForm) {
            /** @var GradesService $GradesService */
            $gradesService = $container->get(GradesService::class);
            $users = $gradesService->getGradesFormUsers();
    }
    return $gradesForm;
}
}