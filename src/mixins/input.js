export default {
    data() {
        return {
            // Data used to handle mouse-drag
            dragActive: false,
            dragStart: null,
            dragAmount: 0,
            dragInputRef: null,
            dragValue: null
        };
    },

    created() {
        // Bind to the document, as it will not be fired when there is no hover on the item
        document.addEventListener('mouseup', this.onMouseUp);
        document.addEventListener('mousemove', this.onMouseDrag);
    },

    methods: {
        onInput(event) {
            this.store(event.target.value);
        },

        incrementInput(inputEl, step = 1) {
            const max = inputEl.getAttribute('max');
            if (!max) return;

            let value = parseInt(inputEl.value, 10);
            value = Math.min(value + step, max);
            if (value < 0) value = 0;

            this.store(value, inputEl);
        },

        amplifyStepFromEvent(event, step = 1, amplification = 10) {
            return event && (event.metaKey || event.shiftKey)
                ? step * amplification
                : step;
        },

        // Keyboard up arrow press
        onUp(event) {
            this.incrementInput(
                event.target,
                this.amplifyStepFromEvent(event, 1)
            );
        },

        // Keyboard down arrow press
        onDown(event) {
            this.incrementInput(
                event.target,
                this.amplifyStepFromEvent(event, -1)
            );
        },

        // Function to handle changing values by incrementing with the mouse
        onMouseDown(event, inputRef) {
            if (!this.dragActive && inputRef && event.pageY) {
                this.dragActive = true;
                this.dragInputRef = inputRef;
                this.dragStart = event.pageY;
                this.dragValue = parseInt(inputRef.value, 10);
            }
        },

        onMouseUp(event) {
            if (!this.dragActive || !this.dragInputRef || !event.pageY) return;

            // Get value
            this.dragAmount = this.dragStart - event.pageY;

            // Apply color to store
            this.dragInputRef.value = this.dragValue;

            // Needs to be reset so increment works
            // Note: Creates a lag in the value change
            if (this.dragInputRef && this.dragAmount !== 0) {
                this.incrementInput(this.dragInputRef, this.dragAmount);
            }

            // Reset
            this.dragActive = false;
            this.dragAmount = 0;
            this.dragInputRef = null;
            this.dragValue = null;
        },

        onMouseDrag(event) {
            if (!this.dragActive || !this.dragInputRef || !event.pageY) return;

            // Calculate value
            const max = this.dragInputRef.getAttribute('max');
            if (!max) return;

            this.dragAmount = this.dragStart - event.pageY;

            let newValue = Math.min(this.dragValue + this.dragAmount, max);
            if (newValue < 0) newValue = 0;

            // Visually change the value without changing the store
            this.dragInputRef.value = newValue;
        }
    },

    unmounted() {
        document.removeEventListener('mouseup', this.onMouseUp);
        document.removeEventListener('mousemove', this.onMouseDrag);
    }
};
