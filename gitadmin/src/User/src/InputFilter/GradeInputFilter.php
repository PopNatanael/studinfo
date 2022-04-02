<?php

declare(strict_types=1);

namespace Frontend\User\InputFilter;

use Frontend\User\Entity\User;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\InArray;

/**
 * Class EditUserInputFilter
 * @package Frontend\User\InputFilter
 */
class GradeInputFilter extends InputFilter
{
    public function init()
    {
        parent::init();

        $this->add([
            'name' => 'identity',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim']
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty'
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 3,
                        'max' => 150,
                        'message' => '<b>Identity</b> must have between 3 and 150 characters',
                    ]
                ],
            ]
        ]);

        $this->add([
            'name' => 'grade',
            'required' => false,
            'filters' => [
                ['name' => 'StringTrim']
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty'
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 2,
                        'message' => '<b>Grade</b> must be valid',
                    ]
                ],
            ]
        ]);

        $this->add([
            'name' => 'classes',
            'required' => true,
            'filters' => [],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'message' => 'Please select user classes',
                    ]
                ],
            ]
        ]);
    }
}