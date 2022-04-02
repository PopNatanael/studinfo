<?php

declare(strict_types=1);

namespace Frontend\User\Factory;

use Dot\FlashMessenger\FlashMessenger;
use Frontend\App\Plugin\FormsPlugin;
use Frontend\User\Controller\UserController;
use Frontend\User\Form\UserForm;
use Frontend\User\Form\YearForm;
use Frontend\User\Form\AddGradeForm;
use Laminas\Form\Element\Submit;
use Frontend\User\Factory\AddYearDelegator;
use Frontend\User\Service\UserService;
use Frontend\Classs\Service\YearService;
use Frontend\Classs\Service\GradesService;
use Laminas\Authentication\AuthenticationService;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class UserControllerFactory
 * @package Frontend\User\Factory
 */
class UserControllerFactory
{
    /**
     * @param ContainerInterface $container
     * @return UserController
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container)
    {
        $router = $container->get(RouterInterface::class);
        $template = $container->get(TemplateRendererInterface::class);
        $UserService = $container->get(UserService::class);
        $gradeService = $container->get(GradesService::Class);
        $messenger = $container->get(FlashMessenger::class);
        $auth = $container->get(AuthenticationService::class);
        $forms = $container->get(FormsPlugin::class);
        $userForm = $container->get(UserForm::class);
        $gradeForm = $container->get(AddGradeForm::class);


        return new UserController(
            $UserService,
            $gradeService,
            $router,
            $template,
            $auth,
            $messenger,
            $forms,
            $userForm,
            $gradeForm
        );
    }
}
