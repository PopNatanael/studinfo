<?php

declare(strict_types=1);

namespace Frontend\Classs\Form;

use Frontend\User\Entity\User;
use Frontend\Classs\Entity\Year;
use Frontend\Classs\Entity\Classs;
use Frontend\Classs\Entity\Grades;
use Frontend\Classs\Service\GradesService;
use Frontend\Classs\Entity\ClasssInterface;
use Frontend\Classs\FormData\GradesFormData;
// use Frontend\User\InputFilter\UserInputFilter;
use Laminas\Form\Form;
use Laminas\Hydrator\ObjectPropertyHydrator;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterInterface;

/**
 * Class GradesForm
 * @package Frontend\Classs\Form
 */
class GradesForm extends Form
{
    protected InputFilter $inputFilter;

    protected array $users = [];

    /**
     * GradesForm constructor.
     * @param null $name
     * @param array $options
     */
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->init();

        // $this->inputFilter = new GradesInputFilter();
        // $this->inputFilter->init();
    }

    /**
     * @param array $users
     */
    public function setUsers(array $users): void
    {
        $this->users = $users;

        $this->add([
            'name' => 'user',
            'type' => 'select',
            'options' => [
                'label' => 'user',
                'value_options' => $users,
            ],
        ]);
    }

    public function init()
    {
        parent::init();

        $this->setObject(new GradesFormData());
        $this->setHydrator(new ObjectPropertyHydrator());

    }

}