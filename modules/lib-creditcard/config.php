<?php

return [
    '__name' => 'lib-creditcard',
    '__version' => '0.0.2',
    '__git' => 'git@github.com:getmim/lib-creditcard.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'modules/lib-creditcard' => ['install','update','remove'],
        'etc/locale/en-US/form/error/creditcard.php' => ['install','update','remove'],
        'etc/locale/id-ID/form/error/creditcard.php' => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [],
        'optional' => [
            [
                'lib-validator' => NULL
            ]
        ]
    ],
    'autoload' => [
        'classes' => [
            'LibCreditcard\\Library' => [
                'type' => 'file',
                'base' => 'modules/lib-creditcard/library'
            ],
            'LibCreditcard\\Validator' => [
                'type' => 'file',
                'base' => 'modules/lib-creditcard/validator'
            ]
        ],
        'files' => []
    ],
    'libValidator' => [
        'validators' => [
            'creditcard' => 'LibCreditcard\\Validator\\Rule::creditcard'
        ],
        'errors' => [
            '24.0' => 'form.error.creditcard.invalid_number',
            '24.1' => 'form.error.creditcard.is_not_as_of_rule_provider'
        ]
    ],
    'libCreditcard' => [
        'logos' => []
    ]
];
