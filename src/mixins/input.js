export default {
    methods: {
        onInput(event) {
            this.store(event.target.value);
        },

        incrementInput(inputEl, step=1){
            const max = inputEl.getAttribute('max');

            if (!max) {
                return;
            }

            let value = parseInt(inputEl.value, 10);

            if (event.metaKey) {
                step *= 10;
            }

            value = Math.min(value + step, max);

            if (value < 0) {
                value = 0;
            }

            this.store(value, inputEl);
        },

        // Keyboard up arrow press
        onUp(event) {
            const input = event.target;
            this.incrementInput(input, 1);
            return;
        },

        // Keyboard down arrow press
        onDown(event) {
            const input = event.target;
            this.incrementInput(input, -1);
            return;
        },

            }


            }


            }

    }
};
