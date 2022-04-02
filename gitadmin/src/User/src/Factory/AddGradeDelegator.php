<?php

declare(strict_types=1);

namespace Frontend\User\Factory;

use Frontend\User\Form\UserForm;
use Frontend\User\Form\AddGradeForm;
use Frontend\User\Service\UserService;
use Frontend\Classs\Entity\Classs;
use Frontend\Classs\Entity\Grades;
use Frontend\Classs\Entity\ClasssInterface;
use Frontend\Classs\Service\ClassService;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class AddGradeDelegator
 * @package Frontend\User\Factory
 */
class AddGradeDelegator implements DelegatorFactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $name
     * @param callable $callback
     * @param array|null $options
     * @return AddGradeForm|mixed|object
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $name, callable $callback, array $options = null)
    {
        $addGradeForm = $callback();
        if ($addGradeForm instanceof AddGradeForm) {
            /** @var UserService $userService */
            $userService = $container->get(UserService::class);

            $classes = $userService->getUserFormProcessedClasses();

            $addGradeForm->setClasses($classes);
        }

        return $addGradeForm;
    }
}
