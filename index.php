<?php

@include_once __DIR__ . '/vendor/autoload.php';

use Hananils\Colors;

function getValue($value = null)
{
    if (!$value) {
        return;
    }

    $value = Yaml::decode($value);

    if (is_array($value)) {
        $value = $value[0];
    }

    return $value;
}

Kirby::plugin('hananils/colors', [
    'fields' => [
        'colors' => [
            'props' => [
                'value' => function ($value = null) {
                    return getValue($value);
                };
                'help' => function ($help = null) {
                    return $help;
                },
                'alpha' => function (bool $alpha = false) {
                    return $alpha;
                },
                'contrast' => function ($contrast = false) {
                    return $contrast;
                }
            ]
        ]
    ],
    'fieldMethods' => [
        'isHex' => function ($field) {
            $value = getValue($field->value);
            return Colors::isHex($value);
        },
        'isRgb' => function ($field) {
            $value = getValue($field->value);
            return Colors::isRgb($value);
        },
        'isHsl' => function ($field) {
            $value = getValue($field->value);
            return Colors::isHsl($value);
        },
        'toSpace' => function ($field) {
            $value = getValue($field->value);
            $color = new Colors($value);

            return $color->toSpace();
        },
        'toObject' => function ($field) {
            $value = getValue($field->value);
            $color = new Colors($value);

            return $color->toObject();
        },
        'toColor' => function ($field) {
            $value = getValue($field->value);
            $color = new Colors($value);

            return $color->toColor();
        },
        'toMostReadable' => function ($field) {
            $value = getValue($field->value);
            $color = new Colors($value);
            $readable = $color->getMostReadable();
            $format = 'hex';

            if ($color->hasAlpha()) {
                $format = 'hex8';
            }

            return $readable[1]['color']->toColor($format);
        }
    ]
]);
