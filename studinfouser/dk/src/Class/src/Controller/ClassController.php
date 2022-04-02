<?php

namespace Frontend\Classs\Controller;

use Dot\AnnotatedServices\Annotation\Inject;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Dot\Controller\AbstractActionController;
use Dot\FlashMessenger\FlashMessenger;
use Dot\Mail\Exception\MailException;
use Fig\Http\Message\RequestMethodInterface;
use Frontend\Classs\Form\ClassForm;
use Frontend\Classs\Entity\Classs;
use Frontend\Classs\Entity\Grades;
use Frontend\Classs\Entity\Year;
use Frontend\Classs\Service\ClassService;
use Frontend\Classs\Service\GradesService;
use Frontend\Classs\Service\YearService;
use Frontend\User\Service\UserService;
use Frontend\Plugin\FormsPlugin;
use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;

class ClassController extends AbstractActionController
{
    /** @var RouterInterface $router */
    protected RouterInterface $router;

    /** @var TemplateRendererInterface $template */
    protected TemplateRendererInterface $template;

     /** @var ClassService $classService */
     protected ClassService $classService;

     /** @var YearService $yearService */
     protected YearService $yearService;

     /** @var GradesService $gradesService */
     protected GradesService $gradesService;

     /** @var UserService $userService */
     protected UserService $userService;

    /** @var AuthenticationServiceInterface $authenticationService */
    protected AuthenticationServiceInterface $authenticationService;

    /** @var FlashMessenger $messenger */
    protected FlashMessenger $messenger;

    /** @var FormsPlugin $forms */
    protected FormsPlugin $forms;

    /**
     * ClassController constructor.
     * @param ClassService $classService
     * @param YearService $yearService
     * @param GradesService $gradesService
     * @param GradesService $userService
     * @param RouterInterface $router
     * @param TemplateRendererInterface $template
     * @param AuthenticationService $authenticationService
     * @param FlashMessenger $messenger
     * @param FormsPlugin $forms
     * @Inject({
     *     ClassService::class,
     *     YearService::class,
     *     GradesService::class,
     *     UserService::class,
     *     RouterInterface::class,
     *     TemplateRendererInterface::class,
     *     AuthenticationService::class,
     *     FlashMessenger::class,
     *     FormsPlugin::class
     *     })
     */
    public function __construct(
        ClassService $classService,
        YearService $yearService,
        GradesService $gradesService,
        UserService $userService,
        RouterInterface $router,
        TemplateRendererInterface $template,
        AuthenticationService $authenticationService,
        FlashMessenger $messenger,
        FormsPlugin $forms
    ) {
        $this->classService = $classService;
        $this->yearService = $yearService;
        $this->gradesService = $gradesService;
        $this->userService = $userService;
        $this->router = $router;
        $this->template = $template;
        $this->authenticationService = $authenticationService;
        $this->messenger = $messenger;
        $this->forms = $forms;
    }

    /**
     * @return ResponseInterface
     * @throws NonUniqueResultException
     */
    public function studClassAction(): ResponseInterface
    {
        try {
            $auth = $this->authenticationService->getIdentity();
            $user = $this->userService->findByIdentity($auth->getIdentity());
        } catch(NonUniqueResultException $e) {
            return new RedirectResponse($this->router->generateUri("page", ["action" => 'home']));
        }

        $params = $this->getRequest()->getQueryParams();
        $search = (!empty($params['search'])) ? $params['search'] : null;
        $sort = (!empty($params['sort'])) ? $params['sort'] : "created";
        $order = (!empty($params['order'])) ? $params['order'] : "desc";
        $offset = (!empty($params['offset'])) ? (int)$params['offset'] : 0;
        $limit = (!empty($params['limit'])) ? (int)$params['limit'] : 30;
        // $result = $this->classService->getClasses($offset, $limit, $search, $sort, $order);

        return new HtmlResponse(
            $this->template->render('class::studentClasses', [
                'students' => $user->getClasses(), 'year' => $user
            ])
        );
    }
}
