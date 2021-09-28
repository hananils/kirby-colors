<?php

namespace Hananils;

use Hananils\Readability;

class Color
{
    use Converter;

    private $original = null;
    private $space = null;
    private $r = null;
    private $g = null;
    private $b = null;
    private $h = null;
    private $s = null;
    private $l = null;
    private $a = 100;

    public function __construct($color)
    {
        if (is_a($color, 'Hananils\Color')) {
            $values = $color->toValues();
            $this->setValues($values);
        } elseif ($this->isHex($color)) {
            $this->original = $color;
            $this->space = 'hex';
            $this->parseHex($color);
        } elseif ($this->isRgb($color)) {
            $this->original = $color;
            $this->space = 'rgb';
            $this->parseRgb($color);
        } elseif ($this->isHsl($color)) {
            $this->original = $color;
            $this->space = 'hsl';
            $this->parseHsl($color);
        } else {
            $this->setDefault();
        }
    }

    /**
     * Checks
     */

    public function isHex($string)
    {
        if (!$string) {
            return false;
        }

        return strpos($string, '#') === 0;
    }

    public function isRgb($string)
    {
        if (!$string) {
            return false;
        }

        return strpos($string, 'rgb') === 0;
    }

    public function isHsl($string)
    {
        if (!$string) {
            return false;
        }

        return strpos($string, 'hsl') === 0;
    }

    public function hasAlpha()
    {
        return $this->a !== 100;
    }

    /**
     * Parsers
     */

    public function parseHex($string)
    {
        $string = trim($string, '#; ');

        if (strlen($string) < 6) {
            $values = str_split($string, 1);
            foreach ($values as $key => $value) {
                $values[$key] = str_repeat($value, 2);
            }
        } else {
            $values = str_split($string, 2);
        }

        $this->setHex($values);
    }

    public function parseRgb($string)
    {
        preg_match('/\((.*)\)/', $string, $matches);
        $values = preg_split('/[\s,\/]+/', $matches[1]);

        $this->setRgb($values);
    }

    public function parseHsl($string)
    {
        preg_match('/\((.*)\)/', $string, $matches);
        $values = preg_split('/[\s,\/]+/', $matches[1]);

        $this->setHsl($values);
    }

    /**
     * Setters
     */

    public function setDefault()
    {
        $this->setValues([
            'original' => null,
            'space' => 'hex',
            'r' => 255,
            'g' => 255,
            'b' => 255,
            'h' => 0,
            's' => 0,
            'l' => 100,
            'a' => 100
        ]);
    }

    public function setValues($values)
    {
        $this->original = $values['original'];
        $this->space = $values['space'];
        $this->r = $values['r'];
        $this->g = $values['g'];
        $this->b = $values['b'];
        $this->h = $values['h'];
        $this->s = $values['s'];
        $this->l = $values['l'];
        $this->a = $values['a'];
    }

    /* Set by value */

    public function setSpace($format)
    {
        $this->space = $format;
    }

    public function setRed($value)
    {
        $this->r = $this->convertValueToDecimal($value);
    }

    public function setGreen($value)
    {
        $this->g = $this->convertValueToDecimal($value);
    }

    public function setBlue($value)
    {
        $this->b = $this->convertValueToDecimal($value);
    }

    public function setHue($value)
    {
        $this->h = $this->convertValueToDecimal($value);
    }

    public function setSaturation($value)
    {
        $this->s = $this->convertValueToDecimal($value);
    }

    public function setLightness($value)
    {
        $this->l = $this->convertValueToDecimal($value);
    }

    public function setAlpha($value)
    {
        $this->a = $this->convertValueToDecimal($value);
    }

    /* Set by space */

    public function setHex($values)
    {
        if (!$values) {
            $this->setDefault();
            return;
        }

        $this->setRed(hexdec($values[0]));
        $this->setGreen(hexdec($values[1]));
        $this->setBlue(hexdec($values[2]));

        if (count($values) === 4) {
            $this->setAlpha($this->rebaseHexForDecimal($values[3]));
        }

        $this->convertRgbToHsl();
    }

    public function setRgb($values)
    {
        if (!$values) {
            $this->setDefault();
            return;
        }

        $this->setRed($values[0]);
        $this->setGreen($values[1]);
        $this->setBlue($values[2]);

        if (count($values) === 4) {
            $this->setAlpha($values[3]);
        }

        $this->convertRgbToHsl();
    }

    public function setHsl($values)
    {
        if (!$values) {
            $this->setDefault();
            return;
        }

        $this->setHue($values[0]);
        $this->setSaturation($values[1]);
        $this->setLightness($values[2]);

        if (count($values) === 4) {
            $this->setAlpha($values[3]);
        }

        $this->convertHslToRgb();
    }

    /**
     * Getters
     */

    public function getAlpha()
    {
        return $this->a;
    }

    /**
     * Readability
     */

    public function toReadabilityReport($combinations = ['#fff', '#000'])
    {
        $readability = new Readability($this, $combinations);
        return $readability->toReport();
    }

    public function toMostReadable($combinations = ['#fff', '#000'])
    {
        $readability = new Readability($this, $combinations);
        return $readability->toMostReadable();
    }

    /**
     * Results
     */

    public function toOriginal()
    {
        return $this->original;
    }

    public function toSpace()
    {
        return $this->space;
    }

    public function toValues($precision = 0)
    {
        return [
            'original' => $this->original,
            'space' => $this->space,
            'r' => round($this->r, $precision),
            'g' => round($this->g, $precision),
            'b' => round($this->b, $precision),
            'h' => round($this->h, $precision),
            's' => round($this->s, $precision),
            'l' => round($this->l, $precision),
            'a' => round($this->a, $precision)
        ];
    }

    public function toHex()
    {
        return [
            'r' => $this->convertDecimalToHex($this->r),
            'g' => $this->convertDecimalToHex($this->g),
            'b' => $this->convertDecimalToHex($this->b),
            'a' => $this->convertDecimalToHex(
                $this->rebaseDecimalForHex($this->a)
            )
        ];
    }

    public function toRgb($precision = 0)
    {
        return [
            'r' => round($this->r, $precision),
            'g' => round($this->g, $precision),
            'b' => round($this->b, $precision),
            'a' => $this->convertToFloat($this->a, $precision)
        ];
    }

    public function toHsl($precision = 0)
    {
        return [
            'h' => round($this->h, $precision),
            's' => round($this->s, $precision),
            'l' => round($this->l, $precision),
            'a' => $this->convertToFloat($this->a, $precision)
        ];
    }

    public function toString($format = null)
    {
        if (!$format) {
            $format = $this->toSpace();
        }

        if (strpos($format, 'hsl') === 0) {
            $hsl = $this->toHsl();

            if ($this->a < 100) {
                return "hsla({$hsl['h']}, {$hsl['s']}%, {$hsl['l']}%, {$hsl['a']})";
            } else {
                return "hsla({$hsl['h']}, {$hsl['s']}%, {$hsl['l']}%)";
            }
        } elseif (strpos($format, 'rgb') === 0) {
            $rgb = $this->toRgb();

            if ($this->a < 100) {
                return "rgba({$rgb['r']}, {$rgb['g']}, {$rgb['b']}, {$rgb['a']})";
            } else {
                return "rgb({$rgb['r']}, {$rgb['g']}, {$rgb['b']})";
            }
        } else {
            $hex = $this->toHex();

            if ($this->a < 100) {
                return "#{$hex['r']} {$hex['g']}{$hex['b']}{$hex['a']}";
            } else {
                return "#{$hex['r']}{$hex['g']}{$hex['b']}";
            }
        }
    }
}
