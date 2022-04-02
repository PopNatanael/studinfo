<?php

declare(strict_types=1);

namespace Frontend\User\Form;

use Frontend\User\Entity\User;
use Frontend\Classs\Entity\Year;
use Frontend\Classs\Entity\Classs;
use Frontend\Classs\Entity\ClasssInterface;
use Frontend\User\FormData\UserFormData;
use Frontend\User\FormData\AddGradeFormData;
use Frontend\User\InputFilter\UserInputFilter;
use Frontend\User\InputFilter\GradeInputFilter;
use Laminas\Form\Form;
use Laminas\Hydrator\ObjectPropertyHydrator;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterInterface;

/**
 * Class AddGradeForm
 * @package Frontend\User\Form
 */
class AddGradeForm extends Form
{
    protected InputFilter $inputFilter;

    protected array $classes = [];

     /**
     * RegisterForm constructor.
     * @param null $name
     * @param array $options
     */
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->init();

        $this->inputFilter = new GradeInputFilter();
        $this->inputFilter->init();
    }

    /**
     * @param array $classes
     */
    public function setClasses(array $classes): void
    {
        $this->classes = $classes;

        $this->add([
            'name' => 'classes',
            'type' => 'radio',
            'options' => [
                'label' => 'Classes',
                'value_options' => $classes,
            ],
        ]);
    }

    public function init()
    {
        
        parent::init();

        $this->setObject(new AddGradeFormData());
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
            'name' => 'grade',
            'type' => 'select',
            'options' => [
                'label' => 'Grade',
                'value_options' => [
                    ['value' => '1', 'label' => '1'],
                    ['value' => '2', 'label' => '2'],
                    ['value' => '3', 'label' => '3'],
                    ['value' => '4', 'label' => '4'],
                    ['value' => '5', 'label' => '5'],
                    ['value' => '6', 'label' => '6'],
                    ['value' => '7', 'label' => '7'],
                    ['value' => '8', 'label' => '8'],
                    ['value' => '9', 'label' => '9'],
                    ['value' => '10', 'label' => '10'],
                ]
            ],
            'attributes' => [
                'placeholder' => 'Grade...'
            ]
        ], ['priority' => -10]);
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
