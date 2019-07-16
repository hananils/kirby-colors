import Space from '../space';

class Rgb extends Space {
    static inSpace(string) {
        return string.indexOf('hsl') === 0;
    }

    parse(string) {
        let matches = string.match(/\((.*)\)/);
        let values = matches[0].split(/[\s,\/]+/);

        this.setRed(values[0]);
        this.setGreen(values[1]);
        this.setBlue(values[2]);

        if (values.length === 4) {
            this.setAlpha(values[3]);
        }

        this.convertRgbToHsl();
    }
}

export default Rgb;
