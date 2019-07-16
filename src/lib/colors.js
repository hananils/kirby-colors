import Readability from './readability';
import Hex from './space/hex';
import Rgb from './space/rgb';
import Hsl from './space/hsl';

class Colors {
    constructor(color) {
        if (color instanceof Colors) {
            this.space = color.toSpace();
        } else if (this.isHex(color)) {
            this.space = new Hex(color);
        } else if (this.isRgb(color)) {
            this.space = new Rgb(color);
        } else if (this.isHsl(color)) {
            this.space = new Hsl(color);
        } else {
            this.space = new Hex('#fff');
        }
    }

    /**
     * Validators
     */

    isHex(string) {
        return Hex.inSpace(string) === true;
    }

    isRgb(string) {
        return Rgb.inSpace(string) === true;
    }

    isHsl(string) {
        return Hsl.inSpace(string) === true;
    }

    hasAlpha() {
        return this.space.hasAlpha();
    }

    /**
     * Readability
     */

    checkReadability(combinations = ['#fff', '#000']) {
        let readability = new Readability(this.combinations);
        return readability.toObject();
    }

    getMostReadable(combinations = ['#fff', '#000']) {
        let readability = new Readability(this.combinations);
        return readability.toMostReadable();
    }

    /**
     * Output
     */

    toSpace() {
        return this.space;
    }

    toObject() {
        return this.space.toObject();
    }

    toColor(format = 'hex', precision = 0) {
        return this.space.toString(format, precision);
    }
}

export default Colors;
