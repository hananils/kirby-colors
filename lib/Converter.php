<?php

namespace Hananils;

/**
 * Converts colors from one color space to another.
 *
 * Based on TinyColor by Scott Cooper and originally Brian Grinstead:
 * https://github.com/TypeCtrl/tinycolor (MIT licensed)
 *
 * See: https://stackoverflow.com/questions/2353211/hsl-to-rgb-color-conversion
 */
trait Converter
{
    /**
     * See: https://www.w3.org/TR/2011/REC-css3-color-20110607/#hsl-color
     */
    public function convertHslToRgb()
    {
        $hue = $this->h / 360;
        $saturation = $this->s / 100;
        $lightness = $this->l / 100;

        $red = $lightness;
        $green = $lightness;
        $blue = $lightness;

        if ($saturation !== 0) {
            $m2 =
                $lightness < 0.5
                    ? $lightness * (1 + $saturation)
                    : $lightness + $saturation - $lightness * $saturation;
            $m1 = 2 * $lightness - $m2;

            $red = $this->convertHueToRgb($m1, $m2, $hue + 1 / 3);
            $green = $this->convertHueToRgb($m1, $m2, $hue);
            $blue = $this->convertHueToRgb($m1, $m2, $hue - 1 / 3);
        }

        $this->r = $red * 255;
        $this->g = $green * 255;
        $this->b = $blue * 255;
    }

    /**
     * See: https://www.w3.org/TR/2011/REC-css3-color-20110607/#hsl-color
     */
    public function convertHueToRgb($m1, $m2, $hue)
    {
        if ($hue < 0) {
            $hue += 1;
        }

        if ($hue > 1) {
            $hue -= 1;
        }

        if ($hue < 1 / 6) {
            return $m1 + ($m2 - $m1) * 6 * $hue;
        }

        if ($hue < 1 / 2) {
            return $m2;
        }

        if ($hue < 2 / 3) {
            return $m1 + ($m2 - $m1) * (2 / 3 - $hue) * 6;
        }

        return $m1;
    }

    public function convertRgbToHsl()
    {
        $red = $this->r / 255;
        $green = $this->g / 255;
        $blue = $this->b / 255;

        $max = max($red, $green, $blue);
        $min = min($red, $green, $blue);
        $add = $max + $min;
        $sub = $max - $min;

        $hue = 0;
        $saturation = 0;
        $lightness = $add / 2;

        if ($min != $max) {
            if ($lightness < 0.5) {
                $saturation = $sub / $add;
            } else {
                $saturation = 2 - $max - $min;
                $saturation = $sub / $saturation;
            }

            switch ($max) {
                case $red:
                    $hue = $green - $blue;
                    $hue = $hue / $sub;
                    break;
                case $green:
                    $hue = $blue - $red;
                    $hue = $hue / $sub;
                    $hue = $hue + 2;
                    break;
                case $blue:
                    $hue = $red - $green;
                    $hue = $hue / $sub;
                    $hue = $hue + 4;
                    break;
            }
        }

        $hue *= 60;

        if ($hue < 0) {
            $hue += 360;
        }

        $this->h = $hue;
        $this->s = $saturation * 100;
        $this->l = $lightness * 100;
    }

    public function convertValueToDecimal($value)
    {
        $number = floatval($value);

        if ($number < 1 && strpos($value, '%') === false) {
            $number = $number * 100;
        }

        return $number;
    }

    public function convertDecimalToHex($number, $pad = true)
    {
        $hex = dechex(round($number));

        if ($pad) {
            $hex = str_pad($hex, 2, '0', STR_PAD_LEFT);
        }

        return $hex;
    }

    public function convertHexToDecimal($hex)
    {
        return hexdec($hex);
    }

    public function convertToFloat($number)
    {
        return round($number) / 100;
    }

    public function rebaseDecimalForHex($number)
    {
        return round(($number / 100) * 255);
    }

    public function rebaseHexForDecimal($hex)
    {
        $decimal = $this->convertHexToDecimal($hex);
        return round(($decimal / 255) * 100);
    }
}
