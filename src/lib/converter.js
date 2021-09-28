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
        const hue = this.h / 360;
        const saturation = this.s / 100;
        const lightness = this.l / 100;

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

        this.r = red * 255;
        this.g = green * 255;
        this.b = blue * 255;
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
            return m1 + (m2 - m1) * 6 * hue;
        }

        if (hue < 1 / 2) {
            return m2;
        }

        if (hue < 2 / 3) {
            return m1 + (m2 - m1) * (2 / 3 - hue) * 6;
        }

        return m1;
    }

    convertRgbToHsl() {
        const red = this.r / 255;
        const green = this.g / 255;
        const blue = this.b / 255;

        const max = Math.max(red, green, blue);
        const min = Math.min(red, green, blue);
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

        this.h = hue;
        this.s = saturation * 100;
        this.l = lightness * 100;
    }

    convertValueToDecimal(value) {
        let number = parseFloat(value);

        if (number < 1 && !value.toString().includes('%')) {
            number = number * 100;
        }

        return number;
    }

    convertDecimalToHex(number, pad = true) {
        let hex = Math.round(number).toString(16);

        if (pad) {
            hex = hex.padStart(2, '0');
        }

        return hex;
    }

    convertHexToDecimal(hex) {
        return parseInt(hex, 16);
    }

    convertToFloat(number) {
        return Math.round(number) / 100;
    }

    rebaseDecimalForHex(number) {
        return Math.round((number / 100) * 255);
    }

    rebaseHexForDecimal(hex) {
        const decimal = this.convertHexToDecimal(hex);
        return Math.round((decimal / 255) * 100);
    }

    round(number, precision = 0) {
        if (precision > 0) {
            return number.toPrecision(precision);
        }

        return Math.round(number);
    }
}

export default Converter;
