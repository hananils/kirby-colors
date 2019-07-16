<?php

namespace Hananils\Spaces;

use Hananils\Space;

class Hex extends Space
{
    public static function inSpace($string)
    {
        return strpos($string, '#') === 0;
    }

    public function parse($string)
    {
        $string = trim($string, '#;');

        if (strlen($string) < 6) {
            $values = str_split($string, 1);
            foreach ($values as $key => $value) {
                $values[$key] = str_repeat($value, 2);
            }
        } else {
            $values = str_split($string, 2);
        }

        $this->setRed(hexdec($values[0]));
        $this->setGreen(hexdec($values[1]));
        $this->setBlue(hexdec($values[2]));

        if (isset($values[3])) {
            $this->setAlpha(
                hexdec($values[3]) / 255
            );
        }

        $this->convertRgbToHsl();
    }
}
