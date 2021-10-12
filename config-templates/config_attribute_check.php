<?php

declare(strict_types=1);

$config = [
    'attribute_groups' => [
        'group_identifier1' => [
            'attribute_list' => ['attr1', 'attr2'],
            'type' => 'MANDATORY_AT_LEAST_ONE/MANDATORY_ALL/OPTIONAL',
            'translates' => [
                'title' => [
                    'en' => 'TITLE',
                ],
                'OK' => [
                    'title' => [
                        'en' => 'OK',
                    ],
                    'description' => [
                        'en' => 'OK',
                    ],
                ],
                'NOT_OK' => [
                    'title' => [
                        'en' => 'ERROR',
                    ],
                    'description' => [
                        'en' => "One of 'attr1', 'attr2' must be released.",
                    ],
                ],
            ],
        ],
        [/*...*/],
    ],
];
