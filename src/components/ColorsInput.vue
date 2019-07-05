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
import { TinyColor } from '@ctrl/tinycolor';
import input from '../mixins/input';

export default {
    mixins: [input],
    props: {
        color: Object,
        space: String
    },
    computed: {
        hex() {
            if (this.color.originalInput !== '') {
                return this.color.toHex();
            }
        },
        rgb() {
            return this.color.toRgb();
        },
        hsl() {
            let hsl = this.color.toHsl();

            hsl.h = Math.round(hsl.h);
            hsl.s = Math.round(hsl.s * 100);
            hsl.l = Math.round(hsl.l * 100);

            return hsl;
        }
    },
    methods: {
        store(value, input) {
            let color = value;

            if (color.indexOf('#') === -1) {
                color = '#' + color;
            }

            if (this.space === 'rgb') {
                color = {
                    r: this.$refs.r.value,
                    g: this.$refs.g.value,
                    b: this.$refs.b.value
                };
            } else if (this.space === 'hsl') {
                color = {
                    h: this.$refs.h.value,
                    s: this.$refs.s.value,
                    l: this.$refs.l.value
                };
            }

            // Set value from arrow interactions
            if (input) {
                color[input.dataset.unit] = value;
            }

            color = new TinyColor(color);
            color.setAlpha(this.color.getAlpha());

            this.$emit('input', color.toString());
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
}

.k-colors-input:focus,
.k-colors-input:active {
    color: var(--focus);
}

.k-colors-input.is-hex {
    flex-basis: 5rem;
}
</style>
