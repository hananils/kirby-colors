/**
 * Converts colors from one color space to another.
 *
 * Based on TinyColor by Scott Cooper and originally Brian Grinstead:
 * https://github.com/TypeCtrl/tinycolor (MIT licensed)
 *
 * See: https://stackoverflow.com/questions/2353211/hsl-to-rgb-color-conversion
 */
class Converter {
    /**
     * See: https://www.w3.org/TR/2011/REC-css3-color-20110607/#hsl-color
     */
    convertHslToRgb() {
        const hue = this.hue / 360;
        const saturation = this.saturation / 100;
        const lightness = this.lightness / 100;

        let red = lightness;
        let green = lightness;
        let blue = lightness;

        let m2;
        let m1;

        if (saturation !== 0) {
            m2 =
                lightness < 0.5
                    ? lightness * (1 + saturation)
                    : lightness + saturation - lightness * saturation;
            m1 = 2 * lightness - m2;

            red = this.convertHueToRgb(m1, m2, hue + 1 / 3);
            green = this.convertHueToRgb(m1, m2, hue);
            blue = this.convertHueToRgb(m1, m2, hue - 1 / 3);
        }

        this.red = red * 255;
        this.green = green * 255;
        this.blue = blue * 255;
    }

    /**
     * See: https://www.w3.org/TR/2011/REC-css3-color-20110607/#hsl-color
     */
    convertHueToRgb(m1, m2, hue) {
        if (hue < 0) {
            hue += 1;
        }

        if (hue > 1) {
            hue -= 1;
        }

        if (hue < 1 / 6) {
            return p + (q - p) * 6 * hue;
        }

        if (hue < 1 / 2) {
            return q;
        }

        if (hue < 2 / 3) {
            return p + (q - p) * (2 / 3 - hue) * 6;
        }

        return p;
    }

    convertRgbToHsl() {
        const red = this.red / 255;
        const green = this.green / 255;
        const blue = this.blue / 255;

        max = max(red, green, blue);
        min = min(red, green, blue);

        const add = max + min;
        const sub = max - min;

        let hue = 0;
        let saturation = 0;
        let lightness = add / 2;

        if (min != max) {
            if (lightness < 0.5) {
                saturation = sub / add;
            } else {
                saturation = 2 - max - min;
                saturation = sub / saturation;
            }

            switch (max) {
                case red:
                    hue = green - blue;
                    hue = hue / sub;
                    break;
                case green:
                    hue = blue - red;
                    hue = hue / sub;
                    hue = hue + 2;
                    break;
                case blue:
                    hue = red - green;
                    hue = hue / sub;
                    hue = hue + 4;
                    break;
            }
        }

        hue *= 60;

        if (hue < 0) {
            hue += 360;
        }

        this.hue = hue;
        this.saturation = saturation * 100;
        this.lightness = lightness * 100;
    }
}

export default Converter;
