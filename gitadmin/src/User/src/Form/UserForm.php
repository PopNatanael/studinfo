<?php

declare(strict_types=1);

namespace Frontend\User\Form;

use Frontend\User\Entity\User;
use Frontend\Classs\Entity\Year;
use Frontend\Classs\Entity\Classs;
use Frontend\Classs\Entity\ClasssInterface;
use Frontend\User\FormData\UserFormData;
use Frontend\User\InputFilter\UserInputFilter;
use Laminas\Form\Form;
use Laminas\Hydrator\ObjectPropertyHydrator;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterInterface;

/**
 * Class UserForm
 * @package Frontend\User\Form
 */
class UserForm extends Form
{
    protected InputFilter $inputFilter;

    protected array $roles = [];

    protected array $classes = [];

    protected array $years = [];

    /**
     * RegisterForm constructor.
     * @param null $name
     * @param array $options
     */
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->init();

        $this->inputFilter = new UserInputFilter();
        $this->inputFilter->init();
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;

        $this->add([
            'name' => 'roles',
            'type' => 'MultiCheckbox',
            'options' => [
                'label' => 'Roles',
                'value_options' => $roles,
            ],
        ]);
    }

    /**
     * @param array $classes
     */
    public function setClasses(array $classes): void
    {
        $this->classes = $classes;

        $this->add([
            'name' => 'classes',
            'type' => 'MultiCheckbox',
            'options' => [
                'label' => 'Classes',
                'value_options' => $classes,
            ],
        ]);
    }
    
    /**
     * @param array $years
     */
    public function setYears(array $years): void
    {
        $this->years = $years;

        $this->add([
            'name' => 'year',
            'type' => 'select',
            'options' => [
                'label' => 'year',
                'value_options' => $years,
            ],
        ]);
    }

    public function init()
    {
        
        parent::init();

        $this->setObject(new UserFormData());
        $this->setHydrator(new ObjectPropertyHydrator());

        $this->add([
            'name' => 'identity',
            'type' => 'text',
            'options' => [
                'label' => 'Identity'
            ],
            'attributes' => [
                'placeholder' => 'Identity...'
            ]
        ], ['priority' => -9]);

        $this->add([
            'name' => 'password',
            'type' => 'password',
            'options' => [
                'label' => 'Password'
            ],
            'attributes' => [
                'placeholder' => 'Password...'
            ]
        ], ['priority' => -9]);

        $this->add([
            'name' => 'passwordConfirm',
            'type' => 'password',
            'options' => [
                'label' => 'Password Confirm'
            ],
            'attributes' => [
                'placeholder' => 'Password Confirm...'
            ]
        ], ['priority' => -9]);

        $this->add([
            'name' => 'firstName',
            'type' => 'text',
            'options' => [
                'label' => 'First name'
            ],
            'attributes' => [
                'placeholder' => 'First name...'
            ]
        ], ['priority' => -10]);

        $this->add([
            'name' => 'lastName',
            'type' => 'text',
            'options' => [
                'label' => 'Last name'
            ],
            'attributes' => [
                'placeholder' => 'Last name...'
            ]
        ], ['priority' => -11]);

        $this->add([
            'name' => 'status',
            'type' => 'select',
            'options' => [
                'label' => 'Account Status',
                'value_options' => [
                    ['value' => User::STATUS_ACTIVE, 'label' => User::STATUS_ACTIVE],
                    ['value' => User::STATUS_PENDING, 'label' => User::STATUS_PENDING]
                ]
            ],
        ], ['priority' => -30]);
    }

    /**
     * @return InputFilter|InputFilterInterface|null
     */
    public function getInputFilter()
    {
        return $this->inputFilter;
    }

    /**
     * @param InputFilter $inputFilter
     */
    public function setDifferentInputFilter(InputFilter $inputFilter)
    {
        $this->inputFilter = $inputFilter;
        $this->inputFilter->init();
    }
}
