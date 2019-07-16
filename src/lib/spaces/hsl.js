import Space from '../space';

class Hsl extends Space {
    static inSpace(string) {
        return string.indexOf('hsl') === 0;
    }

    parse(string) {
        let matches = string.match(/\((.*)\)/);
        let values = matches[0].split(/[\s,\/]+/);

        this.setHue(values[0]);
        this.setSaturation(values[1]);
        this.setLightness(values[2]);

        if (values.length === 4) {
            this.setAlpha(values[3]);
        }

        this.convertHslToRgb();
    }
}

export default Hsl;
