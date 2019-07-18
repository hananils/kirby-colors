export default {
    methods: {
        onInput(event) {
            this.store(event.target.value);
        },
        onUp(event) {
            let input = event.target;
            let max = input.getAttribute('max');

            if (!max) {
                return;
            }

            let value = parseInt(input.value, 10);
            let step = 1;

            if (event.metaKey) {
                step = 10;
            }

            value = Math.min(value + step, max);

            if (value < 0) {
                value = 0;
            }

            this.store(value, input);
        },
        onDown(event) {
            let input = event.target;
            let min = input.getAttribute('min');

            if (!min) {
                return;
            }

            let value = parseInt(input.value, 10);
            let step = 1;

            if (event.metaKey) {
                step = 10;
            }

            value = Math.max(min, value - step);

            if (value < 0) {
                value = 0;
            }

            this.store(value, input);
        }
    }
};
