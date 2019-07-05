<?php

Kirby::plugin('hananils/colors', [
    'fields' => [
        'colors' => [
            'props' => [
                'value' => function ($value = null) {
                    return Yaml::decode($value);
                },
                'help' => function ($help = null) {
                    return $help;
                },
                'alpha' => function (bool $alpha = false) {
                    return $alpha;
                },
                'contrast' => function ($contrast = false) {
                    return $contrast;
                }
            ],
            'save' => function ($value) {
                return Yaml::encode($value);
            }
        ]
    ],
    'fieldMethods' => [
        'isHex' => function ($field) {
            $color = $field->toColor();
            return strpos($color, '#') === 0;
        },
        'isRgb' => function ($field) {
            return strpos($field->value, 'rgb') === 0;
        },
        'isHsl' => function ($field) {
            return strpos($field->value, 'hsl') === 0;
        },
        'toColors' => function ($field) {
            return Yaml::decode($field->value);
        },
        'toColor' => function ($field) {
            $colors = $field->toColors();
            return $colors[0];
        },
        'toReadableColor' => function ($field) {
            $colors = $field->toColors($field);
            return $colors[1];
        }
    ]
]);
