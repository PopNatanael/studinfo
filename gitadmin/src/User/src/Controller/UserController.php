<?php

declare(strict_types=1);

namespace Frontend\User\Controller;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Dot\Controller\AbstractActionController;
use Dot\FlashMessenger\FlashMessenger;
use Frontend\App\Plugin\FormsPlugin;
use Frontend\User\Entity\User;
use Frontend\User\Form\UserForm;
use Frontend\User\Form\AddGradeForm;
use Frontend\User\Form\YearForm;
use Frontend\User\Factory\AddYearDelegator;
use Frontend\User\FormData\UserFormData;
use Frontend\User\FormData\AddGradeFormData;
use Frontend\User\InputFilter\EditUserInputFilter;
use Frontend\User\InputFilter\GradeInputFilter;
use Frontend\User\Service\UserService;
use Frontend\Classs\Service\YearService;
use Frontend\Classs\Service\GradesService;
use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Class UserController
 * @package Frontend\User\Controller
 */
class UserController extends AbstractActionController
{
    protected RouterInterface $router;

    protected TemplateRendererInterface $template;

    protected UserService $userService;

    protected GradesService $gradeService;

    protected AuthenticationServiceInterface $authenticationService;

    protected FlashMessenger $messenger;

    protected FormsPlugin $forms;

    protected UserForm $userForm;

    protected AddGradeForm $gradeForm;

    /**
     * UserController constructor.
     * @param UserService $userService
     * @param GradesService $gradeService
     * @param RouterInterface $router
     * @param TemplateRendererInterface $template
     * @param AuthenticationService $authenticationService
     * @param FlashMessenger $messenger
     * @param FormsPlugin $forms
     * @param UserForm $userForm
     * @param AddGradeForm $gradeForm
     */
    public function __construct(
        UserService $userService,
        GradesService $gradeService,
        RouterInterface $router,
        TemplateRendererInterface $template,
        AuthenticationService $authenticationService,
        FlashMessenger $messenger,
        FormsPlugin $forms,
        UserForm $userForm,
        AddGradeForm $gradeForm
    ) {
        $this->userService = $userService;
        $this->gradeService = $gradeService;
        $this->router = $router;
        $this->template = $template;
        $this->authenticationService = $authenticationService;
        $this->messenger = $messenger;
        $this->forms = $forms;
        $this->userForm = $userForm;
        $this->gradeForm = $gradeForm;
    }

    /**
     * @return ResponseInterface
     */
    public function manageAction(): ResponseInterface
    {
        return new HtmlResponse($this->template->render('user::list'));
    }

    /**
     * @return ResponseInterface
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function listAction(): ResponseInterface
    {
        $params = $this->getRequest()->getQueryParams();

        $search = (!empty($params['search'])) ? $params['search'] : null;
        $sort = (!empty($params['sort'])) ? $params['sort'] : "created";
        $order = (!empty($params['order'])) ? $params['order'] : "desc";
        $offset = (!empty($params['offset'])) ? (int)$params['offset'] : 0;
        $limit = (!empty($params['limit'])) ? (int)$params['limit'] : 30;

        $result = $this->userService->getUsers($offset, $limit, $search, $sort, $order);

        return new JsonResponse($result);
    }

    /**
     * @return ResponseInterface
     */
    public function addAction(): ResponseInterface
    {
        $request = $this->request;

        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();
            $this->userForm->setData($data);
            if ($this->userForm->isValid()) {
                $result = $this->userForm->getData();
                try {
                    $this->userService->createUser($result);
                    return new JsonResponse(['success' => 'success', 'message' => 'User created successfully']);
                } catch (Throwable $e) {
                    return new JsonResponse(['success' => 'error', 'message' => $e->getMessage()]);
                }
            } else {
                return new JsonResponse(
                    [
                        'success' => 'error',
                        'message' => $this->forms->getMessagesAsString($this->userForm)
                    ]
                );
            }
        }

        return new HtmlResponse(
            $this->template->render(
                'partial::ajax-form',
                [
                    'form' => $this->userForm,
                    'formAction' => '/user/add'
                ]
            )
        );
    }

    /**
     * @return ResponseInterface
     * @throws NonUniqueResultException
     */
    public function gradeAction(): ResponseInterface
    {
        $request = $this->getRequest();
        $uuid = $request->getAttribute('uuid');
        $user = $this->userService->getUserRepository()->find($uuid);
        $formData = new AddGradeFormData();
        $formData->fromEntity($user);

        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();

            $this->gradeForm->setData($data);
            if ($this->gradeForm->isValid()) {

                $result = $this->gradeForm->getData();
                try {
                    $this->userService->addGrade($user, $result);
                    return new JsonResponse(['success' => 'success', 'message' => 'User updated successfully']);
                } catch (Throwable $e) {
                    return new JsonResponse(['success' => 'error', 'message' => 'Error adding grade']);
                }
            } else {
                return new JsonResponse(
                    [
                        'success' => 'error',
                        'message' => $this->forms->getMessagesAsString($this->gradeForm)
                    ]
                );
            }
        }

        $this->gradeForm->bind($formData);

        return new HtmlResponse(
            $this->template->render(
                'partial::ajax-form',
                [
                    'form' => $this->gradeForm,
                    'formAction' => '/user/grade/' . $uuid
                ]
            )
        );
    }

    /**
     * @return ResponseInterface
     * @throws NonUniqueResultException
     */
    public function editAction(): ResponseInterface
    {
        $request = $this->getRequest();
        $uuid = $request->getAttribute('uuid');
        $user = $this->userService->getUserRepository()->find($uuid);
        $formData = new UserFormData();

        $formData->fromEntity($user);

        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();

            $this->userForm->setData($data);
            $this->userForm->setDifferentInputFilter(new EditUserInputFilter());
            if ($this->userForm->isValid()) {
                $result = $this->userForm->getData();
                try {
                    $this->userService->updateUser($user, $result);
                    return new JsonResponse(['success' => 'success', 'message' => 'User updated successfully']);
                } catch (Throwable $e) {
                    return new JsonResponse(['success' => 'error', 'message' => $e->getMessage()]);
                }
            } else {
                return new JsonResponse(
                    [
                        'success' => 'error',
                        'message' => $this->forms->getMessagesAsString($this->userForm)
                    ]
                );
            }
        }

        $this->userForm->bind($formData);

        return new HtmlResponse(
            $this->template->render(
                'partial::ajax-form',
                [
                    'form' => $this->userForm,
                    'formAction' => '/user/edit/' . $uuid
                ]
            )
        );
    }

    /**
     * @return ResponseInterface
     * @throws NonUniqueResultException
     */
    public function deleteAction(): ResponseInterface
    {
        $request = $this->getRequest();
        $data = $request->getParsedBody();

        if (!empty($data['uuid'])) {
            $user = $this->userService->getUserRepository()->find($data['uuid']);
        } else {
            return new JsonResponse(['success' => 'error', 'message' => 'Could not find user']);
        }

        try {
            $user->setIsDeleted(User::IS_DELETED_YES);
            $user->setIdentity('anonymous' . date('dmYHis') . '@dotkernel.com');
            $userDetails = $user->getDetail();
            $userClasses = $user->getClasses();
            $userYear = $user->getYear();
            $userDetails->setFirstName('anonymous' . date('dmYHis'));
            $userDetails->setLastName('anonymous' . date('dmYHis'));
            $user->setDetail($userDetails);
            $user->setStatus('pending');
            $user->resetClasses();

            $this->userService->getUserRepository()->saveUser($user);
            return new JsonResponse(['success' => 'success', 'message' => 'User Deleted Successfully']);
        } catch (Throwable $e) {
            return new JsonResponse(['success' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
