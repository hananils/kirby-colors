import Converter from './converter';
import Readability from './readability';

class Color extends Converter {
    constructor(color) {
        super();

        this.original = null;
        this.space = null;
        this.r = null;
        this.g = null;
        this.b = null;
        this.h = null;
        this.s = null;
        this.l = null;
        this.a = 100;

        if (color instanceof Color) {
            let values = color.toValues();
            this.setValues(values);
        } else if (this.isHex(color)) {
            this.original = color;
            this.space = 'hex';
            this.parseHex(color);
        } else if (this.isRgb(color)) {
            this.original = color;
            this.space = 'rgb';
            this.parseRgb(color);
        } else if (this.isHsl(color)) {
            this.original = color;
            this.space = 'hsl';
            this.parseHsl(color);
        } else {
            this.setDefault();
        }
    }

    /**
     * Checks
     */

    isHex(string) {
        if (!string) {
            return false;
        }

        return string.indexOf('#') === 0;
    }

    isRgb(string) {
        if (!string) {
            return false;
        }

        return string.indexOf('rgb') === 0;
    }

    isHsl(string) {
        if (!string) {
            return false;
        }

        return string.indexOf('hsl') === 0;
    }

    hasAlpha() {
        return this.a !== 100;
    }

    /**
     * Parsers
     */

    parseHex(string) {
        let values;
        string = string.replace(/[#; ]/g, '');

        if (string.length < 6) {
            values = string.match(/.{1}/g);
            values.forEach(function (value, key) {
                values[key] = value.repeat(2);
            });
        } else {
            values = string.match(/.{2}/g);
        }

        this.setHex(values);
    }

    parseRgb(string) {
        let matches = string.match(/\((.*)\)/);
        let values = matches[1].split(/[\s,\/]+/);

        this.setRgb(values);
    }

    parseHsl(string) {
        let matches = string.match(/\((.*)\)/);
        let values = matches[1].split(/[\s,\/]+/);

        this.setHsl(values);
    }

    /**
     * Setters
     */

    setDefault() {
        this.setValues({
            original: null,
            space: 'hex',
            r: 255,
            g: 255,
            b: 255,
            h: 0,
            s: 0,
            l: 100,
            a: 100
        });
    }

    setValues(values) {
        this.original = values.original;
        this.space = values.space;
        this.r = values.r;
        this.g = values.g;
        this.b = values.b;
        this.h = values.h;
        this.s = values.s;
        this.l = values.l;
        this.a = values.a;
    }

    /* Set by value */

    setSpace(format) {
        this.space = format;
    }

    setRed(value) {
        this.r = this.convertValueToDecimal(value);
    }

    setGreen(value) {
        this.g = this.convertValueToDecimal(value);
    }

    setBlue(value) {
        this.b = this.convertValueToDecimal(value);
    }

    setHue(value) {
        this.h = this.convertValueToDecimal(value);
    }

    setSaturation(value) {
        this.s = this.convertValueToDecimal(value);
    }

    setLightness(value) {
        this.l = this.convertValueToDecimal(value);
    }

    setAlpha(value) {
        this.a = this.convertValueToDecimal(value);
    }

    /* Set by space */

    setHex(values) {
        if (!values) {
            this.setDefault();
            return;
        }

        this.setRed(parseInt(values[0], 16));
        this.setGreen(parseInt(values[1], 16));
        this.setBlue(parseInt(values[2], 16));

        if (values.length === 4) {
            this.setAlpha(this.rebaseHexForDecimal(values[3]));
        }

        this.convertRgbToHsl();
    }

    setRgb(values) {
        if (!values) {
            this.setDefault();
            return;
        }

        this.setRed(values[0]);
        this.setGreen(values[1]);
        this.setBlue(values[2]);

        if (values.length === 4) {
            this.setAlpha(values[3]);
        }

        this.convertRgbToHsl();
    }

    setHsl(values) {
        if (!values) {
            this.setDefault();
            return;
        }

        this.setHue(values[0]);
        this.setSaturation(values[1]);
        this.setLightness(values[2]);

        if (values.length === 4) {
            this.setAlpha(values[3]);
        }

        this.convertHslToRgb();
    }

    /**
     * Getters
     */

    getAlpha() {
        return this.a;
    }

    /**
     * Readability
     */

    toReadabilityReport(combinations = ['#fff', '#000']) {
        let readability = new Readability(this, combinations);
        return readability.toReport();
    }

    toMostReadable(combinations = ['#fff', '#000']) {
        let readability = new Readability(this, combinations);
        return readability.toMostReadable();
    }

    /**
     * Results
     */

    toOriginal() {
        return this.original;
    }

    toSpace() {
        return this.space;
    }

    toValues(precision = 0) {
        return {
            original: this.original,
            space: this.space,
            r: this.round(this.r),
            g: this.round(this.g),
            b: this.round(this.b),
            h: this.round(this.h),
            s: this.round(this.s),
            l: this.round(this.l),
            a: this.round(this.a)
        };
    }

    toHex() {
        return {
            r: this.convertDecimalToHex(this.r),
            g: this.convertDecimalToHex(this.g),
            b: this.convertDecimalToHex(this.b),
            a: this.convertDecimalToHex(this.rebaseDecimalForHex(this.a))
        };
    }

    toRgb(precision = 0) {
        return {
            r: this.round(this.r),
            g: this.round(this.g),
            b: this.round(this.b),
            a: this.convertToFloat(this.a)
        };
    }

    toHsl(precision = 0) {
        return {
            h: this.round(this.h),
            s: this.round(this.s),
            l: this.round(this.l),
            a: this.convertToFloat(this.a)
        };
    }

    toString(format = null) {
        if (!format) {
            format = this.toSpace();
        }

        if (format.indexOf('hsl') === 0) {
            const hsl = this.toHsl();

            if (this.a < 100) {
                return `hsla(${hsl.h}, ${hsl.s}%, ${hsl.l}%, ${hsl.a})`;
            } else {
                return `hsla(${hsl.h}, ${hsl.s}%, ${hsl.l}%)`;
            }
        } else if (format.indexOf('rgb') === 0) {
            const rgb = this.toRgb();

            if (this.a < 100) {
                return `rgba(${rgb.r}, ${rgb.g}, ${rgb.b}, ${rgb.a})`;
            } else {
                return `rgb(${rgb.r}, ${rgb.g}, ${rgb.b})`;
            }
        } else {
            const hex = this.toHex();

            if (this.a < 100) {
                return `#${hex.r}${hex.g}${hex.b}${hex.a}`;
            } else {
                return `#${hex.r}${hex.g}${hex.b}`;
            }
        }
    }
}

export default Color;
