<template>
    <label class="k-colors-opacity">
        <input
            ref="a"
            class="k-colors-input is-alpha"
            :value="opacity"
            data-unit="opacity"
            type="text"
            min="0"
            max="100"
            @input="onInput"
            @keydown.up.prevent="onUp"
            @keydown.down.prevent="onDown"
        />
        <span @mousedown.prevent="onMouseDown($event, $refs.a)">%</span>
    </label>
</template>

<script>
import input from '../mixins/input';

export default {
    mixins: [input],

    props: {
        color: Object
    },

    computed: {
        opacity() {
            return this.color.getAlpha();
        }
    },

    methods: {
        store(value) {
            const opacity = parseInt(value, 10);
            const space = this.color.toSpace();

            this.color.setAlpha(opacity);
            this.$emit('change-opacity', this.color.toString(space));
        }
    }
};
</script>

<style>
.k-colors-opacity {
    display: flex;
    flex-wrap: nowrap;
    align-items: center;
    position: relative;
}

.k-colors-opacity::before {
    content: '';
    position: absolute;
    top: 0.25rem;
    left: 0;
    bottom: 0.25rem;
    border-left: 1px solid var(--color-border);
}

.k-colors-input.is-alpha {
    flex-basis: 2.25rem;
    min-width: 0;
    margin-left: 0.25rem;
    text-align: right;
}

.k-colors-opacity span {
    width: 1rem;
    margin-left: 0.1rem;
    color: var(--color-border);
}
</style>
