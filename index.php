<?php

Kirby::plugin('hananils/colors', [
    'fields' => [
        'colors' => [
            'computed' => [
                'value' => function ($value = null) {
                    return Yaml::decode($value);
                }
            ]
        ]
    ]
]);
