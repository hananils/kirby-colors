export default {
    data: function(){
        return {
            // Data used to handle mouse-drag
            dragActive: false,
            dragStart: null,
            dragAmount: 0,
            dragInputRef: null,
            dragValue: null,
        }
    },
    created(){
        // Bind to the document, as it will not be fired when there is no hover on the item.
        document.addEventListener('mouseup', this.onMouseUp);
        document.addEventListener('mousemove', this.onMouseDrag);
    },
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

        // Function to handle changing values by incrementing with the mouse
        onMouseDown(e, inputRef){
            if(!this.dragActive && inputRef && e.pageY){
                this.dragActive = true;
                this.dragInputRef = inputRef;
                this.dragStart = e.pageY;
                this.dragValue = parseInt(inputRef.value, 10);
            }
        },
        onMouseUp(e){
            if(this.dragActive && this.dragInputRef && e.pageY){
                // Get value
                this.dragAmount = this.dragStart - e.pageY;

                // Apply color to store
                this.dragInputRef.value = this.dragValue; // Needs to be reset so increment works. Note: Creates a lag in the value change.
                if(this.dragInputRef && this.dragAmount!==0) this.incrementInput(this.dragInputRef, this.dragAmount);

                // Reset
                this.dragActive = false;
                this.dragAmount = 0;
                this.dragInputRef = null;
                this.dragValue = null;
            }

        },
        onMouseDrag(e){
            if(this.dragActive && this.dragInputRef && e.pageY){

                // Calc value
                const max = this.dragInputRef.getAttribute('max');
                if (!max) return;
                this.dragAmount = this.dragStart - e.pageY;
                let newValue = Math.min(this.dragValue + this.dragAmount, max);
                if (newValue < 0) newValue = 0;

                // Visually change the value without changing the store
                this.dragInputRef.value = newValue;

            }

        },
    }
};
