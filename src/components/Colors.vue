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
                v-if="opacity !== false"
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
export default {
    inheritAttrs: false,
    props: {
        name: [String, Number],
        label: String,
        default: {
            type: String,
            default: '#fff'
        },
        value: Object,
        contrast: [Boolean, Object],
        invalid: Boolean
    },
    computed: {
        color() {
            let value;

            if ('color' in this.value) {
                value = this.value.color;
            } else {
                value = this.default;
            }

            return tinycolor(value);
        },
        contrast() {
            return this.value.contrast;
        },
        space() {
            return this.color.getFormat();
        }
    },
    methods: {
        onInput(value) {
            this.store(value);
        },
        onChangeSpace(converter) {
            this.store(this.color[converter]());
        },
        onChangeOpacity(value) {
            this.store(value);
        },
        store(value) {
            let contrast = this.getContrast(value);

            console.log({
                color: value,
                contrast: contrast
            });

            this.$emit('input', {
                color: value,
                contrast: contrast
            });
        },
        getContrast(value) {
            let contrast = this.readable(value);

            if (contrast) {
                return contrast.toString();
            }
        },
        readable() {
            let colors = this.contrast;

            if (!colors || colors === true) {
                colors = ['#fff', '#000'];
            }

            return tinycolor.mostReadable(this.color, colors);
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
