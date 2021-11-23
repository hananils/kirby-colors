<template>
    <div class="k-colors-units">
        <template v-if="space === 'rgb'">
            <label class="k-colors-label">
                <span @mousedown.prevent="onMouseDown($event, $refs.r)">R</span>
                <input
                    ref="r"
                    class="k-colors-input"
                    data-unit="r"
                    :value="rgb.r"
                    type="text"
                    min="0"
                    max="255"
                    @input="onInput"
                    @keydown.up.prevent="onUp"
                    @keydown.down.prevent="onDown"
                />
            </label>
            <label class="k-colors-label">
                <span @mousedown.prevent="onMouseDown($event, $refs.g)">G</span>
                <input
                    ref="g"
                    class="k-colors-input"
                    data-unit="g"
                    :value="rgb.g"
                    type="text"
                    min="0"
                    max="255"
                    @input="onInput"
                    @keydown.up.prevent="onUp"
                    @keydown.down.prevent="onDown"
                />
            </label>
            <label class="k-colors-label">
                <span @mousedown.prevent="onMouseDown($event, $refs.b)">B</span>
                <input
                    ref="b"
                    class="k-colors-input"
                    data-unit="b"
                    :value="rgb.b"
                    type="text"
                    min="0"
                    max="255"
                    @input="onInput"
                    @keydown.up.prevent="onUp"
                    @keydown.down.prevent="onDown"
                />
            </label>
        </template>
        <template v-else-if="space === 'hsl'">
            <label class="k-colors-label">
                <span @mousedown.prevent="onMouseDown($event, $refs.h)">H</span>
                <input
                    ref="h"
                    class="k-colors-input"
                    data-unit="h"
                    :value="hsl.h"
                    type="text"
                    min="0"
                    max="360"
                    @input="onInput"
                    @keydown.up.prevent="onUp"
                    @keydown.down.prevent="onDown"
                />
            </label>
            <label class="k-colors-label">
                <span @mousedown.prevent="onMouseDown($event, $refs.s)">S</span>
                <input
                    ref="s"
                    class="k-colors-input"
                    data-unit="s"
                    :value="hsl.s"
                    type="text"
                    min="0"
                    max="100"
                    @input="onInput"
                    @keydown.up.prevent="onUp"
                    @keydown.down.prevent="onDown"
                />
            </label>
            <label class="k-colors-label">
                <span @mousedown.prevent="onMouseDown($event, $refs.l)">L</span>
                <input
                    ref="l"
                    class="k-colors-input"
                    data-unit="l"
                    :value="hsl.l"
                    type="text"
                    min="0"
                    max="100"
                    @input="onInput"
                    @keydown.up.prevent="onUp"
                    @keydown.down.prevent="onDown"
                />
            </label>
        </template>
        <template v-else>
            <label class="k-colors-label">
                <span>#</span>
                <input
                    ref="hex"
                    class="k-colors-input is-hex"
                    :value="hex"
                    type="text"
                    @change="onInput"
                />
            </label>
        </template>
    </div>
</template>

<script>
import Color from '../lib/color';
import input from '../mixins/input';

export default {
    mixins: [input],

    props: {
        color: {
            validator: function (value) {
                return value instanceof Color;
            }
        },
        space: String
    },

    computed: {
        hex() {
            return this.color.toOriginal()
                ? this.color.toString('hex').substr(1, 6)
                : null;
        },

        rgb() {
            return this.color.toRgb();
        },

        hsl() {
            return this.color.toHsl();
        }
    },

    methods: {
        // Used by `onUp`, `onDown`, `onMouseUp`, `onMouseDown`, `onMouseMove`
        // to modify the values
        store(value, input) {
            const fields = this.$refs;
            let values = {};

            if (!value) {
                this.$emit('input', '');
                return;
            }

            if (this.space !== 'hex') {
                for (const key of Object.keys(fields)) {
                    if (fields[key]) {
                        values[key] = fields[key].value;
                    }
                }

                if (input) {
                    values[input.dataset.unit] = value;
                }
            }

            // Set value from arrow interactions
            switch (this.space) {
                case 'hex':
                    this.color.parseHex(value);
                    break;
                case 'rgb':
                    this.color.setRgb([values.r, values.g, values.b]);
                    break;
                case 'hsl':
                    this.color.setHsl([values.h, values.s, values.l]);
                    break;
            }

            this.$emit('input', this.color.toString());
        }
    }
};
</script>

<style>
.k-colors-units {
    display: flex;
    grid-column-start: 2;
    min-width: 0;
    padding: 0 0.25rem 0 0.5rem;
}

.k-colors-label {
    display: flex;
    flex: 1 1 4rem;
    flex-wrap: nowrap;
    align-items: center;
    min-width: 0;
    height: 2.25rem;
    color: var(--color-border);
    font-size: 0.875rem;
}

.k-colors-label:focus-within {
    color: var(--color-border);
}

.k-colors-label span {
    flex: 0 0 0.9rem;
}

.k-colors-input {
    flex: 0 0 3rem;
    min-width: 0;
    height: 1.75rem;
    font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, Courier,
        monospace;
    font-size: 1rem;
    border: none;
    outline: none;
    background: transparent;
}

.k-colors-input:focus,
.k-colors-input:active {
    color: var(--color-focus);
}

.k-colors-input.is-hex {
    flex-basis: 5rem;
}
</style>
