<?php

declare(strict_types=1);

namespace Frontend\User\Factory;

use Frontend\User\Form\YearForm;
use Frontend\User\Service\UserService;
use Frontend\Classs\Service\YearService;
use Laminas\Form\Element\Submit;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class AddYearDelegator
 * @package Frontend\User\Factory
 */
class AddYearDelegator implements DelegatorFactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $name
     * @param callable $callback
     * @param array|null $options
     * @return AdminForm|mixed|object
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $name, callable $callback, array $options = null)
    {
        $YearForm = $callback();
        if ($YearForm instanceof YearForm) {
            /** @var YearService $yearService */
            $yearService = $container->get(YearService::class);
        }

        return $YearForm;
    }
}
