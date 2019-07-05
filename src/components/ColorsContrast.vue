<template>
    <k-input
        ref="input"
        :id="_uid"
        v-bind="$props"
        theme="field"
        class="k-colors-contrast"
    >
        <div
            class="k-colors-color"
            :style="{ background: value }"
            :data-rating="rating"
        ></div>
    </k-input>
</template>

<script>
import { readability, mostReadable } from '@ctrl/tinycolor';

export default {
    props: {
        color: Object,
        contrast: [Boolean, Array]
    },
    computed: {
        readable() {
            let colors = this.contrast;

            if (!colors) {
                colors = ['#fff', '#000'];
            }

            return mostReadable(this.color, colors);
        },
        rating() {
            let score = readability(this.color, this.readable);
            let rating = 'AALarge';

            if (score >= 7) {
                rating = 'AAA';
            } else if (score >= 4.5) {
                rating = 'AA / AAALarge';
            }

            return rating;
        },
        value() {
            if (!this.readable) {
                return;
            }

            return this.readable.toString();
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
    left: -24px;
    width: 16px;
    height: 16px;
    border: 2px solid var(--dark-background);
    border-radius: 50%;
    background-image: linear-gradient(
        to right,
        var(--light-grey) 0%,
        var(--light-grey) 50%,
        var(--dark-background) 50%
    );
}

.k-colors-contrast .k-colors-color::before {
    content: attr(data-rating);
    position: absolute;
    top: -1.725rem;
    right: 0;
    color: var(--dark);
    font-size: 0.75rem;
    font-weight: 600;
    white-space: nowrap;
}
</style>
