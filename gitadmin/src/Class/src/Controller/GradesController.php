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
use Frontend\Classs\Service\ClassService;
use Frontend\Classs\Entity\Classs;
use Frontend\Classs\Entity\Grades;
use Frontend\Classs\Entity\Year;
use Frontend\Classs\Service\GradesService;
use Frontend\Classs\Service\YearService;
use Frontend\Classs\Form\GradesForm;
use Frontend\App\Plugin\FormsPlugin;
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

     /** @var ClassService $classService */
     protected ClassService $classService;

    /** @var GradesService $gradesService */
    protected GradesService $gradesService;

    /** @var YearService $yearService */
    protected YearService $yearService;

    /** @var AuthenticationServiceInterface $authenticationService */
    protected AuthenticationServiceInterface $authenticationService;

    /** @var FlashMessenger $messenger */
    protected FlashMessenger $messenger;

    /** @var FormsPlugin $forms */
    protected FormsPlugin $forms;

    /** @var GradesForm $gradesForm */
    protected GradesForm $gradesForm;

    /**
     * GradesController constructor.
     * @param ClassService $classService
     * @param GradesService $gradesService
     * @param YearService $yearService
     * @param RouterInterface $router
     * @param TemplateRendererInterface $template
     * @param AuthenticationService $authenticationService
     * @param FlashMessenger $messenger
     * @param FormsPlugin $forms
     * @param GradesForm $gradesForm
     * @Inject({
     *     ClassService::class,
     *     GradesService::class,
     *     YearService::class,
     *     RouterInterface::class,
     *     TemplateRendererInterface::class,
     *     AuthenticationService::class,
     *     FlashMessenger::class,
     *     FormsPlugin::class,
     *     GradesForm::class
     *     })
     */
    public function __construct(
        ClassService $classService,
        GradesService $gradesService,
        YearService $yearService,
        RouterInterface $router,
        TemplateRendererInterface $template,
        AuthenticationService $authenticationService,
        FlashMessenger $messenger,
        FormsPlugin $forms,
        GradesForm $gradesForm
    ) {
        $this->classService = $classService;
        $this->gradesService = $gradesService;
        $this->yearService = $yearService;
        $this->router = $router;
        $this->template = $template;
        $this->authenticationService = $authenticationService;
        $this->messenger = $messenger;
        $this->forms = $forms;
        $this->gradesForm = $gradesForm;
    }

    /**
     * @return ResponseInterface
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function listerAction(): ResponseInterface
    {
        $params = $this->getRequest()->getQueryParams();
        $search = (!empty($params['search'])) ? $params['search'] : null;
        $sort = (!empty($params['sort'])) ? $params['sort'] : "created";
        $order = (!empty($params['order'])) ? $params['order'] : "desc";
        $offset = (!empty($params['offset'])) ? (int)$params['offset'] : 0;
        $limit = (!empty($params['limit'])) ? (int)$params['limit'] : 30;

        $result = $this->gradesService->getAllGrades($offset, $limit, $search, $sort, $order);
        return new JsonResponse($result);
    }

    /**
     * @return ResponseInterface
     * @throws NonUniqueResultException
     */
    public function gradeAction():ResponseInterface
    {
        $request = $this->request;

        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();
            $this->gradesForm->setData($data);
            if ($this->gradesForm->isValid()) {
                $result = $this->gradesForm->getData();
                try {

                    $this->gradesService->createUser($result);
                    return new JsonResponse(['success' => 'success', 'message' => 'Grade added successfully']);
                } catch (Throwable $e) {
                    return new JsonResponse(['success' => 'error', 'message' => $e->getMessage()]);
                }
            } else {
                return new JsonResponse(
                    [
                        'success' => 'error',
                        'message' => $this->forms->getMessagesAsString($this->gradesForm)
                    ]
                );
            }
        }

        return new HtmlResponse(
            $this->template->render(
                'partial::ajax-form',
                [
                    'form' => $this->gradesForm,
                    'formAction' => '/grades/grades'
                ]
            )
        );
    }

    /**
     * @return ResponseInterface
     */
    public function gradelistAction(): ResponseInterface
    {
        return new HtmlResponse($this->template->render('class::gradesDisplayTable'));
    }
}
