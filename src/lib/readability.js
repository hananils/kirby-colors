import Color from './color';

/**
 * Compares colors and generates an accessibility report following the
 * WCAG accessibility guidelines.
 *
 * This class is inspired by Brent Jackson's Colorable:
 * https://github.com/jxnblk/colorable (MIT licensed),
 * https://colorable.jxnblk.com/
 */
class Readability {
    constructor(color = '#fff', combinations = ['#fff', '#000']) {
        this.color = new Color(color);
        this.combinations = [];
        this.highest = 0;

        for (const combination of combinations) {
            const color = new Color(combination);
            const contrast = this.setContrastRatio(color);
            const accessibility = this.setRating(contrast);

            this.combinations.push({
                color,
                contrast,
                accessibility
            });
        }
    }

    setContrastRatio(combination) {
        const base = this.getLuminance(this.color);
        const comparison = this.getLuminance(combination);

        if (base > comparison) {
            return (base + 0.05) / (comparison + 0.05);
        }

        return (comparison + 0.05) / (base + 0.05);
    }

    /**
     * See: https://www.w3.org/TR/WCAG20/#visual-audio-contrast
     */
    setRating(ratio) {
        const ratings = [];

        if (ratio >= 3) {
            ratings.push('aaLarge');
        }

        if (ratio >= 4.5) {
            ratings.push('aaaLarge');
            ratings.push('aa');
        }

        if (ratio >= 7) {
            ratings.push('aaa');
        }

        if (ratings.length > this.highest) {
            this.highest = ratings.length;
        }

        return ratings;
    }

    /**
     * Based on TinyColor by Scott Cooper and originally Brian Grinstead:
     * https://github.com/TypeCtrl/tinycolor (MIT licensed)
     *
     * See: http://www.w3.org/TR/2008/REC-WCAG20-20081211/#relativeluminancedef
     */
    getLuminance(color) {
        const values = color.toValues();

        const red = values.r / 255;
        const green = values.g / 255;
        const blue = values.b / 255;

        let r;
        let g;
        let b;

        if (red <= 0.03928) {
            r = red / 12.92;
        } else {
            r = Math.pow((red + 0.055) / 1.055, 2.4);
        }

        if (green <= 0.03928) {
            g = green / 12.92;
        } else {
            g = Math.pow((green + 0.055) / 1.055, 2.4);
        }

        if (blue <= 0.03928) {
            b = blue / 12.92;
        } else {
            b = Math.pow((blue + 0.055) / 1.055, 2.4);
        }

        return 0.2126 * r + 0.7152 * g + 0.0722 * b;
    }

    /**
     * Output
     */

    toReport() {
        return {
            color: this.color,
            combinations: this.combinations
        };
    }

    toMostReadable() {
        return this.combinations.filter(
            (combination) =>
                combination['accessibility'].length === this.highest
        );
    }
}

export default Readability;
