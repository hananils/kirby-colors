<?php

namespace Hananils\Spaces;

class Space
{
    use Converter;

    private $original;
    private $red = null;
    private $green = null;
    private $blue = null;
    private $hue = null;
    private $saturation = null;
    private $lightness = null;
    private $alpha = 100;

    public function __construct($string)
    {
        if (!$this::inSpace($string)) {
            return false;
        }

        $this->original = $string;
        $this->parse($string);
    }

    public static function inSpace($string)
    {
        return false;
    }

    public function hasAlpha()
    {
        return $this->alpha !== 100;
    }

    /**
     * Setters
     */

    public function setRed($value)
    {
        $this->red = floatval($value);
    }

    public function setGreen($value)
    {
        $this->green = floatval($value);
    }

    public function setBlue($value)
    {
        $this->blue = floatval($value);
    }

    public function setHue($value)
    {
        $this->hue = floatval($value);
    }

    public function setSaturation($value)
    {
        $this->saturation = $this->fromFraction($value);
    }

    public function setLightness($value)
    {
        $this->lightness = $this->fromFraction($value);
    }

    public function setAlpha($value)
    {
        $this->alpha = $this->fromFraction($value);
    }

    /**
     * Getters
     */

    public function toObject()
    {
        return [
            'original' => $this->original,
            'red' => $this->red,
            'green' => $this->green,
            'blue' => $this->blue,
            'hue' => $this->hue,
            'saturation' => $this->saturation,
            'lightness' => $this->lightness,
            'alpha' => $this->alpha
        ];
    }

    public function toString($format = 'hex', $precision = 0)
    {
        if (strpos($format, 'hsl') === 0) {
            $hue = round($this->hue, $precision);
            $saturation = round($this->saturation, $precision);
            $lightness = round($this->lightness, $precision);

            if ($format === 'hsla') {
                $alpha = round($this->alpha, $precision) / 100;

                return "hsla({$hue}, {$saturation}%, {$lightness}%, {$alpha})";
            } else {
                return "hsl({$hue}, {$saturation}%, {$lightness}%)";
            }
        } elseif (strpos($format, 'rgb') === 0) {
            $red = round($this->red, $precision);
            $green = round($this->green, $precision);
            $blue = round($this->blue, $precision);

            if ($format === 'rgba') {
                $alpha = round($this->alpha, $precision) / 100;

                return "rgba({$red}, {$green}, {$blue}, {$alpha})";
            } else {
                return "rgb({$red}, {$green}, {$blue})";
            }
        } else {
            $red = $this->toPaddedHex($this->red);
            $green = $this->toPaddedHex($this->green);
            $blue = $this->toPaddedHex($this->blue);
            $alpha = '';

            if ($format === 'hex8') {
                $alpha = $this->toPaddedHex(ceil($this->alpha) / 100 * 255);
            }

            return "#{$red}{$green}{$blue}{$alpha}";
        }
    }

    /**
     * Utilities
     */

    private function fromFraction($value)
    {
        $number = floatval($value);

        if (strpos($value, '%') === false) {
            $number = $number * 100;
        }

        return $number;
    }

    private function toFraction($value)
    {
        return floatval($value) / 100;
    }

    private function toPaddedHex($number)
    {
        return str_pad(dechex($number), 2, '0', STR_PAD_LEFT);
    }
}
