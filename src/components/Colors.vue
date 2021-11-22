<template>
    <k-field
        v-bind="$props"
        :class="[
            'k-colors-field',
            {
                'shows-contrast': contrast !== false
            }
        ]"
    >
        <k-input
            :id="_uid"
            ref="input"
            v-bind="$props"
            theme="field"
            type="colors"
            @input="store"
        >
            <colors-picker :color="color" @input="store" />
            <colors-input :color="color" :space="space" @input="store" />
            <colors-opacity
                v-if="alpha !== false"
                :color="color"
                @change-opacity="store"
            />
            <colors-spaces :space="space" @change-space="onChangeSpace" />
        </k-input>

        <colors-contrast
            v-if="contrast !== false"
            :color="color"
            :contrast="contrast"
        />
    </k-field>
</template>

<script>
import ColorsContrast from './ColorsContrast.vue';
import ColorsInput from './ColorsInput.vue';
import ColorsOpacity from './ColorsOpacity.vue';
import ColorsPicker from './ColorsPicker.vue';
import ColorsSpaces from './ColorsSpaces.vue';
import Color from '../lib/color';

export default {
    components: {
        ColorsContrast,
        ColorsInput,
        ColorsOpacity,
        ColorsPicker,
        ColorsSpaces
    },

    inheritAttrs: false,

    props: {
        name: [String, Number],
        label: String,
        value: String,
        contrast: [Boolean, Array],
        readability: Boolean,
        alpha: Boolean,
        invalid: Boolean,
        disabled: Boolean,
        required: Boolean,
        help: String
    },

    computed: {
        color() {
            const color = new Color(this.value);

            if (this.alpha === false) {
                color.setAlpha(100);
            }

            return color;
        },

        space() {
            return this.color.toSpace();
        }
    },

    methods: {
        onChangeSpace(format) {
            this.color.setSpace(format);
            this.store(this.color.toString());
        },

        store(value) {
            this.$emit('input', value);
        }
    }
};
</script>

<style>
.k-colors-field {
    --color-contrast-dark: #16171a;
    --color-contrast-dark-background: #2d2f36;
}

.k-colors-field.shows-contrast {
    display: grid;
    grid-gap: 0 1.9rem;
    grid-template-columns: auto 2.25rem;
}

.k-colors-field.shows-contrast .k-input {
    grid-row-start: 2;
}

.k-colors-field .k-input-element {
    display: grid;
    grid-template-columns: 2.25rem auto 3.5rem 2.25rem;
}

.k-colors-field .k-field-footer {
    grid-row-start: 3;
    grid-column-end: -1;
    grid-column-start: 1;
}
</style>
