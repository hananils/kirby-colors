<?php

namespace Hananils\Spaces;

use Hananils\Space;

class Hsl extends Space
{
    public static function inSpace($string)
    {
        return strpos($string, 'hsl') === 0;
    }

    public function parse($string)
    {
        preg_match("/\((.*)\)/", $string, $matches);
        $values = preg_split("/[\s,\/]+/", $matches[1]);

        $this->setHue($values[0]);
        $this->setSaturation($values[1]);
        $this->setLightness($values[2]);

        if (isset($values[3])) {
            $this->setAlpha($values[3]);
        }

        $this->convertHslToRgb();
    }
}
