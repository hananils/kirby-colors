<template>
    <div class="k-colors-units">
        <template v-if="space === 'rgb'">
            <label class="k-colors-label">
                <span>R</span>
                <input
                    class="k-colors-input"
                    ref="r"
                    data-unit="r"
                    :value="rgb.r"
                    type="text"
                    @input="onInput"
                    @keydown.up.prevent="onUp"
                    @keydown.down.prevent="onDown"
                    min="0"
                    max="255"
                />
            </label>
            <label class="k-colors-label">
                <span>G</span>
                <input
                    class="k-colors-input"
                    ref="g"
                    data-unit="g"
                    :value="rgb.g"
                    type="text"
                    @input="onInput"
                    @keydown.up.prevent="onUp"
                    @keydown.down.prevent="onDown"
                    min="0"
                    max="255"
                />
            </label>
            <label class="k-colors-label">
                <span>B</span>
                <input
                    class="k-colors-input"
                    ref="b"
                    data-unit="b"
                    :value="rgb.b"
                    type="text"
                    @input="onInput"
                    @keydown.up.prevent="onUp"
                    @keydown.down.prevent="onDown"
                    min="0"
                    max="255"
                />
            </label>
        </template>
        <template v-else-if="space === 'hsl'">
            <label class="k-colors-label">
                <span>H</span>
                <input
                    class="k-colors-input"
                    ref="h"
                    data-unit="h"
                    :value="hsl.h"
                    type="text"
                    @input="onInput"
                    @keydown.up.prevent="onUp"
                    @keydown.down.prevent="onDown"
                    min="0"
                    max="360"
                />
            </label>
            <label class="k-colors-label">
                <span>S</span>
                <input
                    class="k-colors-input"
                    ref="s"
                    data-unit="s"
                    :value="hsl.s"
                    type="text"
                    @input="onInput"
                    @keydown.up.prevent="onUp"
                    @keydown.down.prevent="onDown"
                    min="0"
                    max="100"
                />
            </label>
            <label class="k-colors-label">
                <span>L</span>
                <input
                    class="k-colors-input"
                    ref="l"
                    data-unit="l"
                    :value="hsl.l"
                    type="text"
                    @input="onInput"
                    @keydown.up.prevent="onUp"
                    @keydown.down.prevent="onDown"
                    min="0"
                    max="100"
                />
            </label>
        </template>
        <template v-else>
            <label class="k-colors-label">
                <span>#</span>
                <input
                    class="k-colors-input is-hex"
                    ref="hex"
                    :value="hex"
                    type="text"
                    @change="onInput"
                />
            </label>
        </template>
    </div>
</template>

<script>
import input from '../mixins/input';

export default {
    mixins: [input],
    props: {
        color: {
            validator: function (value) {
                value instanceof Color;
            }
        },
        space: String
    },
    computed: {
        hex() {
            if (this.color.toOriginal()) {
                return this.color.toString('hex').substr(1, 6);
            }
        },
        rgb() {
            return this.color.toRgb();
        },
        hsl() {
            return this.color.toHsl();
        }
    },
    methods: {
        store(value, input) {
            const fields = this.$refs;
            let values = {};

            if (!value && value !== 0) {
                this.$emit('input', '');
                return;
            }

            if (this.space !== 'hex') {
                Object.keys(fields).forEach(function (key) {
                    if (fields[key]) {
                        values[key] = fields[key].value;
                    }
                });

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
    color: var(--border-grey);
    font-size: 0.875rem;
}

.k-colors-label:focus-within {
    color: var(--border-grey);
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
    color: var(--focus);
}

.k-colors-input.is-hex {
    flex-basis: 5rem;
}
</style>
