<?php

namespace Hananils;

use Hananils\Color;

/**
 * Compares colors and generates an accessibility report following the
 * WCAG accessibility guidelines.
 *
 * This class is inspired by Brent Jackson's Colorable:
 * https://github.com/jxnblk/colorable (MIT licensed),
 * https://colorable.jxnblk.com/
 */
class Readability
{
    private $color;
    private $combinations = [];
    private $highest = 0;

    public function __construct(
        $color = '#fff',
        $combinations = ['#fff', '#000']
    ) {
        $this->color = new Color($color);

        foreach ($combinations as $combination) {
            $color = new Color($combination);
            $ratio = $this->setContrastRatio($color);
            $rating = $this->setRating($ratio);

            $this->combinations[] = [
                'color' => $color,
                'contrast' => $ratio,
                'accessibility' => $rating
            ];
        }
    }

    public function setContrastRatio($combination)
    {
        $base = $this->getLuminance($this->color);
        $comparison = $this->getLuminance($combination);

        if ($base > $comparison) {
            return ($base + 0.05) / ($comparison + 0.05);
        }

        return ($comparison + 0.05) / ($base + 0.05);
    }

    /**
     * See: https://www.w3.org/TR/WCAG20/#visual-audio-contrast
     */
    public function setRating($ratio)
    {
        $ratings = [];

        if ($ratio >= 3) {
            $ratings[] = 'aaLarge';
        }

        if ($ratio >= 4.5) {
            $ratings[] = 'aaaLarge';
            $ratings[] = 'aa';
        }

        if ($ratio >= 7) {
            $ratings[] = 'aaa';
        }

        if (count($ratings) > $this->highest) {
            $this->highest = count($ratings);
        }

        return $ratings;
    }

    /**
     * Based on TinyColor by Scott Cooper and originally Brian Grinstead:
     * https://github.com/TypeCtrl/tinycolor (MIT licensed)
     *
     * See: http://www.w3.org/TR/2008/REC-WCAG20-20081211/#relativeluminancedef
     */
    public function getLuminance($color)
    {
        $values = $color->toValues();
        $red = $values['r'] / 255;
        $green = $values['g'] / 255;
        $blue = $values['b'] / 255;

        if ($red <= 0.03928) {
            $r = $red / 12.92;
        } else {
            $r = pow(($red + 0.055) / 1.055, 2.4);
        }

        if ($green <= 0.03928) {
            $g = $green / 12.92;
        } else {
            $g = pow(($green + 0.055) / 1.055, 2.4);
        }

        if ($blue <= 0.03928) {
            $b = $blue / 12.92;
        } else {
            $b = pow(($blue + 0.055) / 1.055, 2.4);
        }

        return 0.2126 * $r + 0.7152 * $g + 0.0722 * $b;
    }

    /**
     * Output
     */

    public function toReport()
    {
        $report = [
            'color' => $this->color,
            'combinations' => $this->combinations
        ];

        return $report;
    }

    public function toMostReadable()
    {
        $best = array_filter($this->combinations, function ($combination) {
            return count($combination['accessibility']) === $this->highest;
        });

        return $best;
    }
}
