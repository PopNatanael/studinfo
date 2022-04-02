<?php

declare(strict_types=1);

namespace Frontend\Classs\Form;

use Frontend\Contact\InputFilter\ContactInputFilter;
use Laminas\Form\Element\Email;
use Laminas\Form\Element\Text;
use Laminas\Form\Element\Textarea;
use Laminas\Form\Form;
use Laminas\InputFilter\InputFilter;

/**
 * Class ClassForm
 * @package Frontend\Class\Form
 */
class ClassForm extends Form
{
    /** @var InputFilter $inputFilter */
    protected $inputFilter;

    /**
     * ClassForm constructor.
     * @param null $name
     * @param array $options
     */
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->init();

        $this->inputFilter = new ContactInputFilter();
        $this->inputFilter->init();
    }

    public function init()
    {
        parent::init();

        $this->add([
            'name' => 'name',
            'options' => [
                'label' => 'name'
            ],
            'attributes' => [
                'placeholder' => 'Enter class name..'
            ],
            'type' => Text::class
        ]);

        $this->add([
            'name' => 'year',
            'options' => [
                'label' => 'year'
            ],
            'attributes' => [
                'placeholder' => 'Enter year..'
            ],
            'type' => Text::class,
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'type' => 'submit',
                'value' => 'Create Class'
            ]
        ], ['priority' => -105]);
    }

    /**
     * @return null|InputFilter|\Laminas\InputFilter\InputFilterInterface
     */
    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}
