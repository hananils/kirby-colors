<?php

namespace Hananils;

use Hananils\Readability;
use Hananils\Spaces\Hex;
use Hananils\Spaces\Hsl;
use Hananils\Spaces\Rgb;

class Colors
{
    private $space;

    public function __construct($color)
    {
        if (is_a($color, 'Hananils\Colors')) {
            $this->space = $color->toSpace();
        } elseif ($this->isHex($color)) {
            $this->space = new Hex($color);
        } elseif ($this->isRgb($color)) {
            $this->space = new Rgb($color);
        } elseif ($this->isHsl($color)) {
            $this->space = new Hsl($color);
        } else {
            $this->space = new Hex('#fff');
        }
    }

    /**
     * Validators
     */

    public function isHex($string)
    {
        return Hex::inSpace($string) === true;
    }

    public function isRgb($string)
    {
        return Rgb::inSpace($string) === true;
    }

    public function isHsl($string)
    {
        return Hsl::inSpace($string) === true;
    }

    public function hasAlpha()
    {
        return $this->space->hasAlpha();
    }

    /**
     * Readability
     */

    public function checkReadability($combinations = ['#fff', '#000'])
    {
        $readability = new Readability($this, $combinations);
        return $readability->toObject();
    }

    public function getMostReadable($combinations = ['#fff', '#000'])
    {
        $readability = new Readability($this, $combinations);
        return $readability->toMostReadable();
    }

    /**
     * Output
     */

    public function toSpace()
    {
        return $this->space;
    }

    public function toObject()
    {
        return $this->space->toObject();
    }

    public function toColor($format = 'hex', $precision = 0)
    {
        return $this->space->toString($format, $precision);
    }
}
