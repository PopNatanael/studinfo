<?php

declare(strict_types=1);

namespace Frontend\User\Factory;

use Dot\FlashMessenger\FlashMessenger;
use Frontend\App\Plugin\FormsPlugin;
use Frontend\User\Controller\YearController;
use Frontend\User\Form\UserForm;
use Frontend\User\Form\YearForm;
use Laminas\Form\Element\Submit;
use Frontend\User\Factory\AddYearDelegator;
use Frontend\User\Service\UserService;
use Frontend\Classs\Service\YearService;
use Laminas\Authentication\AuthenticationService;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class YearControllerFactory
 * @package Frontend\User\Factory
 */
class YearControllerFactory
{
    /**
     * @param ContainerInterface $container
     * @return YearController
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container)
    {
        $router = $container->get(RouterInterface::class);
        $template = $container->get(TemplateRendererInterface::class);
        $UserService = $container->get(UserService::class);
        $YearService = $container->get(YearService::class);
        $messenger = $container->get(FlashMessenger::class);
        $auth = $container->get(AuthenticationService::class);
        $forms = $container->get(FormsPlugin::class);
        $userForm = $container->get(UserForm::class);
        $yearForm = $container->get(YearForm::class);

        return new YearController(
            $UserService,
            $YearService,
            $router,
            $template,
            $auth,
            $messenger,
            $forms,
            $userForm,
            $yearForm
        );
    }
}
