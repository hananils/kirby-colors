import Space from '../space';

class Hex extends Space {
    static inSpace(string) {
        return string.indexOf('#') === 0;
    }

    parse(string) {
        let values;

        string = string.replace(/[#; ]/g, '');

        if (string.length < 6) {
            values = string.match(/.{1}/g);
            values.forEach(function(value, key) {
                values[key] = value.repeat(2);
            });
        } else {
            values = string.match(/.{2}/g);
        }

        this.setRed(values[0].toString(16));
        this.setGreen(values[1].toString(16));
        this.setBlue(values[2].toString(16));

        if (values.length === 4) {
            this.setAlpha(values[3].toString(16) / 255);
        }

        this.convertRgbToHsl();
    }
}

export default Hex;
