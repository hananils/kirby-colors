<template>
    <k-field
        v-bind="$props"
        :class="{
            'k-colors-field': true,
            'shows-contrast': contrast !== false
        }"
    >
        <k-input
            ref="input"
            :id="_uid"
            v-bind="$props"
            theme="field"
            type="colors"
            @input="onInput"
        >
            <k-colors-picker :color="color" @input="onInput" />
            <k-colors-input :color="color" :space="space" @input="onInput" />
            <k-colors-opacity
                :color="color"
                v-if="alpha !== false"
                @change-opacity="onChangeOpacity"
            />
            <k-colors-spaces :space="space" @change-space="onChangeSpace" />
        </k-input>

        <k-colors-contrast
            :color="color"
            :contrast="contrast"
            v-if="contrast !== false"
        />
    </k-field>
</template>

<script>
import Color from '../lib/color';

export default {
    inheritAttrs: false,
    props: {
        name: [String, Number],
        label: String,
        default: String,
        value: Array,
        contrast: Object,
        readability: Boolean,
        alpha: Boolean,
        invalid: Boolean,
        disabled: Boolean,
        required: Boolean,
        help: String
    },
    computed: {
        color() {
            let value;

            if (this.value) {
                value = this.value;
            } else {
                value = this.default;
            }

            return new Color(value);
        },
        space() {
            return this.color.getSpace();
        }
    },
    methods: {
        onInput(value) {
            this.store(value);
        },
        onChangeSpace(format) {
            this.color.setSpace(format);
            this.store(this.color.toString());
        },
        onChangeOpacity(value) {
            this.store(value);
        },
        store(value) {
            this.$emit('input', value);
        }
    }
};
</script>

<style>
.k-colors-field {
    --dark: #16171a;
    --dark-background: #2d2f36;
    --muted-grey: #777;
    --border-grey: #ccc;
    --light-grey: #efefef;
    --white: #fff;
    --positive: #5d800d;
    --negative: #c82829;
    --focus: #4271ae;
    --notice: #f5871f;
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
</style>
