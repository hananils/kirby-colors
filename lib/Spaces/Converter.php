<?php

namespace Hananils\Spaces;

trait Converter
{
    public function convertHslToRgb()
    {
        $hue = $this->hue / 360;
        $saturation = $this->saturation / 100;
        $lightness = $this->lightness / 100;

        if ($saturation === 0) {
            $red = $lightness;
            $green = $lightness;
            $blue = $lightness;
        } else {
            $q = $lightness < 0.5 ? $lightness * (1 + $saturation) : $lightness + $saturation - $lightness * $saturation;
            $p = 2 * $lightness - $q;

            $red = $this->convertHueToRgb($p, $q, $hue + 1 / 3);
            $green = $this->convertHueToRgb($p, $q, $hue);
            $blue = $this->convertHueToRgb($p, $q, $hue - 1 / 3);
        }

        $this->red = $red * 255;
        $this->green = $green * 255;
        $this->blue = $blue * 255;
    }

    public function convertHueToRgb($p, $q, $hue)
    {
        if ($hue < 0) {
            $hue += 1;
        }

        if ($hue > 1) {
            $hue -= 1;
        }

        if ($hue < 1 / 6) {
            return $p + ($q - $p) * 6 * $hue;
        }

        if ($hue < 1 / 2) {
            return $q;
        }

        if ($hue < 2 / 3) {
            return $p + ($q - $p) * (2 / 3 - $hue) * 6;
        }

        return $p;
    }

    public function convertRgbToHsl()
    {
        $red = $this->red / 255;
        $green = $this->green / 255;
        $blue = $this->blue / 255;

        $max = max($red, $green, $blue);
        $min = min($red, $green, $blue);

        $add = ($max + $min);
        $sub = ($max - $min);

        $hue = 0;
        $saturation = 0;
        $lightness = ($add / 2.0);

        if ($min != $max) {
            if ($lightness < 0.5) {
                $saturation = ($sub / $add);
            } else {
                $saturation = (2.0 - $max - $min);
                $saturation = ($sub / $saturation);
            }

            switch ($max) {
                case $red:
                    $hue = ($green - $blue);
                    $hue = ($hue / $sub);
                    break;
                case $green:
                    $hue = ($blue - $red);
                    $hue = ($hue / $sub);
                    $hue = ($hue + 2.0);
                    break;
                case $blue:
                    $hue = ($red - $green);
                    $hue = ($hue / $sub);
                    $hue = ($hue + 4.0);
                    break;
            }
        }

        $hue *= 60;

        if ($hue < 0) {
            $hue += 360;
        }

        $this->hue = $hue;
        $this->saturation = $saturation * 100;
        $this->lightness = $lightness * 100;
    }
}
