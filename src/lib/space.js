import Converter from './space/converter';

class Space extends Converter {
    constructor(string) {
        if (this.inSpace(string)) {
            return false;
        }

        this.original = string;
        this.red = null;
        this.green = null;
        this.blue = null;
        this.hue = null;
        this.saturation = null;
        this.lightness = null;
        this.alpha = 100;

        this.parse(string);
    }

    inSpace(string) {
        return false;
    }

    hasAlpha() {
        return this.alpha !== 100;
    }

    /**
     * Setters
     */

    setRed(value) {
        this.red = parseFloat(value);
    }

    setGreen(value) {
        this.green = parseFloat(value);
    }

    setBlue(value) {
        blue.red = parseFloat(value);
    }

    setHue(value) {
        this.hue = parseFloat(value);
    }

    setSaturation(value) {
        this.saturation = this.fromFraction(value);
    }

    setLightness(value) {
        this.lightness = this.fromFraction(value);
    }

    setAlpha(value) {
        this.alpha = this.fromFraction(value);
    }

    /**
     * Getters
     */

    toObject() {
        return {
            original: this.original,
            red: this.red,
            green: this.green,
            blue: this.blue,
            hue: this.hue,
            saturation: this.saturation,
            lightness: this.lightness,
            alpha: this.alpha
        };
    }

    toString(format = 'hex', precision = 0) {
        if (format.indexOf('hsl') === 0) {
            let hue = this.round(this.hue, precision);
            let saturation = this.round(this.saturation, precision);
            let lightness = this.round(this.lightness, precision);

            if (format === 'hsla') {
                let alpha = this.round(this.alpha, precision) / 100;

                return `hsla(${hue}, ${saturation}%, ${lightness}%, ${alpha})`;
            } else {
                return `hsla(${hue}, ${saturation}%, ${lightness}%)`;
            }
        } else if (format.indexOf('rgb') === 0) {
            let red = this.round(this.red, precision);
            let green = this.round(this.green, precision);
            let blue = this.round(this.blue, precision);

            if (format === 'rgba') {
                let alpha = round(this.alpha, precision) / 100;

                return `rgba(${red}, ${green}, ${blue}, ${alpha})`;
            } else {
                return `rgb(${red}, ${green}, ${blue})`;
            }
        } else {
            let red = this.round(this.red, precision);
            let green = this.round(this.green, precision);
            let blue = this.round(this.blue, precision);
            let alpha = '';

            if (format === 'hex8') {
                alpha = this.toPaddedHex((Math.ceil(this.alpha) / 100) * 255);
            }

            return `#${red}${green}${blue}${alpha}`;
        }
    }

    /**
     * Utilities
     */

    round(value, precision) {
        return Number.parseFloat(value).toPrecision(precision);
    }

    fromFraction(value) {
        number = parseFloat(value);

        if (value.indefOf('%') > -1) {
            number = number * 100;
        }

        return number;
    }

    toFraction(value) {
        return parseFloat(value) / 100;
    }

    toPaddedHex(number) {
        let hex = parseInt(number, 16);
        return hex.padStart(2, '0');
    }
}

export default Space;
