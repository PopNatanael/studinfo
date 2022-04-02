<?php

namespace Frontend\Classs\Controller;

use Dot\AnnotatedServices\Annotation\Inject;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Dot\Controller\AbstractActionController;
use Dot\FlashMessenger\FlashMessenger;
use Dot\Mail\Exception\MailException;
use Exception;
use Throwable;
use Fig\Http\Message\RequestMethodInterface;
use Frontend\Classs\Form\ClassForm;
use Frontend\Classs\Entity\Classs;
use Frontend\Classs\Entity\Grades;
use Frontend\Classs\Entity\Year;
use Frontend\User\Service\UserService;
use Frontend\Classs\Service\ClassService;
use Frontend\Classs\Service\GradesService;
use Frontend\Classs\Service\YearService;
use Frontend\Plugin\FormsPlugin;
use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;

class GradesController extends AbstractActionController
{
    /** @var RouterInterface $router */
    protected RouterInterface $router;

    /** @var TemplateRendererInterface $template */
    protected TemplateRendererInterface $template;

     /** @var GradesService $gradesService */
     protected GradesService $gradesService;

     /** @var YearService $yearService */
     protected YearService $yearService;

     /** @var ClassService $classService */
     protected ClassService $classService;

    /** @var UserService $userService */
    protected UserService $userService;

    /** @var AuthenticationServiceInterface $authenticationService */
    protected AuthenticationServiceInterface $authenticationService;

    /** @var FlashMessenger $messenger */
    protected FlashMessenger $messenger;

    /** @var FormsPlugin $forms */
    protected FormsPlugin $forms;

    /**
     * GradesController constructor.
     * @param GradesService $gradesService
     * @param ClassService $classService
     * @param UserService $userService
     * @param YearService $yearService
     * @param RouterInterface $router
     * @param TemplateRendererInterface $template
     * @param AuthenticationService $authenticationService
     * @param FlashMessenger $messenger
     * @param FormsPlugin $forms
     * @Inject({
     *     GradesService::class,
     *     ClassService::class,
     *     UserService::class,
     *     YearService::class,
     *     RouterInterface::class,
     *     TemplateRendererInterface::class,
     *     AuthenticationService::class,
     *     FlashMessenger::class,
     *     FormsPlugin::class
     *     })
     */
    public function __construct(
        GradesService $gradesService,
        ClassService $classService,
        UserService $userService,
        YearService $yearService,
        RouterInterface $router,
        TemplateRendererInterface $template,
        AuthenticationService $authenticationService,
        FlashMessenger $messenger,
        FormsPlugin $forms
    ) {
        $this->gradesService = $gradesService;
        $this->classService = $classService;
        $this->userService = $userService;
        $this->yearService = $yearService;
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
    public function studentGradesAction(): ResponseInterface
    {
        try {
            $auth = $this->authenticationService->getIdentity();
            $user = $this->userService->findByIdentity($auth->getIdentity());
        } catch(NonUniqueResultException $e) {
            return new RedirectResponse($this->router->generateUri("page", ["action" => 'home']));
        }

        $request = $this->getRequest();
        $yearRequest = $request->getAttribute("uuid");

        if($yearRequest == null) {
            $yearRequest = $user->getYear()->getUuid();
        }
        else {
            $yearRequest = $request->getAttribute("uuid");
        }

        $params = $this->getRequest()->getQueryParams();
        $search = (!empty($params['search'])) ? $params['search'] : null;
        $sort = (!empty($params['sort'])) ? $params['sort'] : "created";
        $order = (!empty($params['order'])) ? $params['order'] : "desc";
        $offset = (!empty($params['offset'])) ? (int)$params['offset'] : 0;
        $limit = (!empty($params['limit'])) ? (int)$params['limit'] : 30;

        try {
            $year = $this->yearService->getYears();
            $result = $this->gradesService->getGrades($offset, $limit, $yearRequest, $sort, $order, $user->getUuid()->toString());
        } catch (Exception $e) {
            return new RedirectResponse($this->router->generateUri("grades", ['action' => 'studentGrades']));
        }

        return new HtmlResponse(
            $this->template->render('class::gradesDisplay', [
                'grades' => $result,'years' => $year, 'user' => $user
            ])
        );
    }

    /**
     * @return ResponseInterface
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function gradeAction(): ResponseInterface
    {
        try {
            $auth = $this->authenticationService->getIdentity();
            $user = $this->userService->findByIdentity($auth->getIdentity());
        }
        catch(NonUniqueResultException $e) {
            return new RedirectResponse($this->router->generateUri("page", ["action" => 'home']));
        }

        $params = $this->getRequest()->getQueryParams();
        $search = (!empty($params['search'])) ? $params['search'] : null;
        $sort = (!empty($params['sort'])) ? $params['sort'] : "created";
        $order = (!empty($params['order'])) ? $params['order'] : "desc";
        $offset = (!empty($params['offset'])) ? (int)$params['offset'] : 0;
        $limit = (!empty($params['limit'])) ? (int)$params['limit'] : 30;

        try {
            $classes = $this->classService->getClasses();
            $result = $this->gradesService->getGrades($offset, $limit, $search, $sort, $order, $user->getUuid()->toString());
        } catch (Exception $e) {
            return new RedirectResponse($this->router->generateUri("page", ['action' => 'home']));
        }

        return new JsonResponse($result);
    }
}
