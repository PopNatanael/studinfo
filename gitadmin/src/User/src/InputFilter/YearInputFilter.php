<?php

declare(strict_types=1);

namespace Frontend\User\InputFilter;

use Frontend\Classs\Entity\Year;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\InArray;

/**
 * Class AdminInputFilter
 * @package Frontend\User\InputFilter
 */
class YearInputFilter extends InputFilter
{
    public function init()
    {
        parent::init();

        $this->add([
            'name' => 'year',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim']
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'message' => '<b>Year</b> is required and cannot be empty',
                    ]
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 1,
                        'message' => '<b>Year</b> must be valid',
                    ]
                ]
            ]
        ]);

        $this->add([
            'name' => 'status',
            'required' => true,
            'filters' => [],
            'validators' => [
                [
                    'name' => InArray::class,
                    'options' => [
                        'haystack' => [
                            Year::STATUS_ACTIVE,
                            Year::STATUS_DELETED
                        ]
                    ],
                ]
            ]
        ]);
    }
}
