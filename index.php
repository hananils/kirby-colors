<?php

@include_once __DIR__ . '/vendor/autoload.php';

function getValue($value = null)
{
    if (is_array($value)) {
        return $value[0];
    }

    return $value;
}

Kirby::plugin('hananils/colors', [
    'fields' => [
        'colors' => [
            'props' => [
                'value' => function ($value = null) {
                    if (is_array($value)) {
                        return $value[0];
                    }

                    return $value;
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
                return $value;
            }
        ]
    ],
    'fieldMethods' => [
        'isHex' => function ($field) {
            $color = $field->toClass($field);
            return $color->isHex($value);
        },
        'isRgb' => function ($field) {
            $color = $field->toClass($field);
            return $color->isRgb($value);
        },
        'isHsl' => function ($field) {
            $color = $field->toClass($field);
            return $color->isHsl($value);
        },
        'toClass' => function ($field) {
            $value = getValue($field->value);
            return new Hananils\Color($value);
        },
        'toColor' => function ($field) {
            $color = $field->toClass($field);
            return $color->toString();
        },
        'toSpace' => function ($field) {
            $color = $field->toClass($field);
            return $color->toSpace();
        },
        'toValues' => function ($field) {
            $color = $field->toClass($field);
            return $color->toValues();
        },
        'toReport' => function ($field) {
            $color = $field->toClass($field);
            return $color->toReport();
        },
        'toMostReadable' => function ($field) {
            $color = $field->toClass($field);
            $readable = $color->toMostReadable();
            $space = $color->toSpace();

            if (count($readable) === 0) {
                return;
            }

            return array_shift($readable)['color']->toString($space);
        }
    ]
]);
