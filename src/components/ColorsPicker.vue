<template>
    <div class="k-colors-preview">
        <label class="k-colors-color" :style="{ background: value }">
            <input
                class="k-colors-picker"
                type="color"
                @input="onInput"
                :value="hex"
            />
        </label>
    </div>
</template>

<script>
import Color from '../lib/color';

export default {
    props: {
        color: Object
    },
    data: {
        init: false
    },
    computed: {
        value() {
            if (this.color.toOriginal()) {
                return this.color.toString('hex');
            }
        },
        hex() {
            if (this.color.toOriginal()) {
                return this.color.toString('hex').substring(0, 7);
            }
        }
    },
    methods: {
        onInput(event) {
            if (!this.init) {
                this.init = true;
                return;
            }

            let color = new Color(event.target.value);
            let space = this.color.toSpace();

            color.setAlpha(this.color.getAlpha());

            this.$emit('input', color.toString(space));
        }
    }
};
</script>

<style>
.k-colors-preview {
    display: block;
    flex: 0 0 2.25rem;
    width: 2.25rem;
    height: 2.25rem;
    margin-right: 0.5rem;
    background-image: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGZpbGwtcnVsZT0iZXZlbm9kZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIgc3Ryb2tlLW1pdGVybGltaXQ9IjIiIGNsaXAtcnVsZT0iZXZlbm9kZCIgdmlld0JveD0iMCAwIDEyIDEyIj4KICA8cGF0aCBmaWxsPSJub25lIiBkPSJNMCAwaDEydjEySDB6Ii8+CiAgPHBhdGggZmlsbD0iI2ViZWJlYiIgZD0iTTAgMGg2djZIMHpNNS45NTIgNmg2djZoLTZ6Ii8+Cjwvc3ZnPgo=);
    background-size: 0.75rem 0.75rem;
}

.k-colors-color {
    display: block;
    overflow: hidden;
    width: 2.25rem;
    height: 2.25rem;
    border-right: 1px solid var(--border-grey);
}

.k-colors-picker {
    width: 2.25rem;
    height: 2.25rem;
    visibility: hidden;
}
</style>
