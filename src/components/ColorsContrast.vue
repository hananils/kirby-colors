<template>
    <k-input
        :id="_uid"
        ref="input"
        v-bind="$props"
        theme="field"
        class="k-colors-contrast"
    >
        <div
            class="k-colors-color"
            :style="{ background: value }"
            :data-rating="rating"
        />
    </k-input>
</template>

<script>
export default {
    props: {
        color: Object,
        contrast: [Boolean, Array]
    },

    computed: {
        readable() {
            let colors = this.contrast;

            if (colors === true) {
                colors = ['#fff', '#000'];
            }

            return this.color.toMostReadable(colors);
        },

        rating() {
            if (!this.readable.length) {
                return null;
            }

            const [readable] = this.readable;
            return readable.accessibility[readable.accessibility.length - 1];
        },

        value() {
            if (!this.readable.length) {
                return null;
            }

            const [readable] = this.readable;
            return readable.color.toString();
        }
    }
};
</script>

<style>
.k-colors-contrast {
    position: relative;
    width: calc(2.25rem + 1px);
}

.k-colors-contrast::before {
    content: '';
    position: absolute;
    left: -1.5rem;
    width: 1rem;
    height: 1rem;
    border: 2px solid var(--color-contrast-dark-background);
    border-radius: 50%;
    background-image: linear-gradient(
        to right,
        var(--color-background) 0%,
        var(--color-background) 50%,
        var(--color-contrast-dark-background) 50%
    );
}

.k-colors-contrast .k-colors-color::before {
    content: attr(data-rating);
    position: absolute;
    top: -1.725rem;
    right: 0;
    color: var(--color-contrast-dark);
    font-size: 0.75rem;
    font-weight: 600;
    white-space: nowrap;
}

.k-colors-contrast .k-input-element {
    display: block;
}
</style>
