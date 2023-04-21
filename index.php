<?php

@include_once __DIR__ . '/vendor/autoload.php';

Kirby::plugin('hananils/colors', [
    'fields' => [
        'colors' => [
            'props' => [
                'value' => function ($value = null) {
                    return is_array($value) ? $value[0] : $value;
                },
                'help' => function ($help = null) {
                    return I18n::translate($help, $help);
                },
                'alpha' => function (bool $alpha = false) {
                    return $alpha;
                },
                'contrast' => function ($contrast = false) {
                    return $contrast;
                }
            ],
            'computed' => [
                'contrastColors' => function () {
                    $colors = $this->contrast;

                    if ($colors === false) {
                        return false;
                    }

                    if (isset($this->contrast['type'])) {
                        $colors = true;
                        $query = null;

                        if (
                            $this->contrast['type'] === 'query' &&
                            isset($this->contrast['query'])
                        ) {
                            $query = $this->contrast['query'];
                        } elseif (
                            $this->contrast['type'] === 'watch' &&
                            isset($this->contrast['field'])
                        ) {
                            $query = 'page.' . $this->contrast['field'];
                        }

                        if ($query) {
                            $colors = $this->model()->query($query);

                            if (isset($this->contrast['split'])) {
                                $colors = explode(
                                    $this->contrast['split'],
                                    $colors
                                );
                            }

                            if (!is_array($colors)) {
                                $colors = [(string) $colors];
                            }

                            $colors = array_map('trim', $colors);
                            $colors = array_filter($colors, function ($value) {
                                return strlen($value) > 2;
                            });
                        }
                    }

                    if ($colors === true || empty($colors)) {
                        return ['#fff', '#000'];
                    }

                    return $colors;
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
            return $color->toSpace() === 'hex';
        },
        'isRgb' => function ($field) {
            $color = $field->toClass($field);
            return $color->toSpace() === 'rgb';
        },
        'isHsl' => function ($field) {
            $color = $field->toClass($field);
            return $color->toSpace() === 'hsl';
        },
        'toClass' => function ($field) {
            $value = is_array($field->value) ? $field->value[0] : $field->value;
            return new Hananils\Color($value);
        },
        'toColor' => function ($field, $space = null) {
            $color = $field->toClass($field);
            return $color->toString($space);
        },
        'toSpace' => function ($field) {
            $color = $field->toClass($field);
            return $color->toSpace();
        },
        'toValues' => function ($field) {
            $color = $field->toClass($field);
            return $color->toValues();
        },
        'toReadabilityReport' => function ($field) {
            $color = $field->toClass($field);
            $blueprint = $field
                ->model()
                ->blueprint()
                ->fields();
            $name = $field->key();

            if (
                isset($blueprint[$name]['contrast']) &&
                is_array($blueprint[$name]['contrast'])
            ) {
                return $color->toReadabilityReport(
                    $blueprint[$name]['contrast']
                );
            }

            return $color->toReadabilityReport();
        },
        'toMostReadable' => function ($field) {
            $color = $field->toClass($field);
            $blueprint = $field
                ->model()
                ->blueprint()
                ->fields();
            $name = $field->key();

            if (
                isset($blueprint[$name]['contrast']) &&
                is_array($blueprint[$name]['contrast'])
            ) {
                $readable = $color->toMostReadable(
                    $blueprint[$name]['contrast']
                );
            } else {
                $readable = $color->toMostReadable();
            }

            $space = $color->toSpace();

            if (count($readable) === 0) {
                return;
            }

            return array_shift($readable)['color']->toString($space);
        }
    ]
]);
