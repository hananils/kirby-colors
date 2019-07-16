<?php

namespace Hananils\Spaces;

use Hananils\Space;

class Rgb extends Space
{
    public static function inSpace($string)
    {
        return strpos($string, 'rgb') === 0;
    }

    public function parse($string)
    {
        preg_match("/\((.*)\)/", $string, $matches);
        $values = preg_split("/[\s,\/]+/", $matches[1]);

        $this->setRed($values[0]);
        $this->setGreen($values[1]);
        $this->setBlue($values[2]);

        if (isset($values[3])) {
            $this->setAlpha($values[3]);
        }

        $this->convertRgbToHsl();
    }
}
