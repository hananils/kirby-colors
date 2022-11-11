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
        contrast: [Boolean, Array],
        contrastColors: Array
    },

    computed: {
        readable() {
            return this.color.toMostReadable(this.contrastColors);
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
        },

        watching() {
            // fallback colors
            let contrasts = ['#fff', '#000'];

            if (this.isWatching) {
                let value =
                    this.$store.getters['content/changes']()[
                        this.contrast.field
                    ];

                if (value) {
                    contrasts = value;

                    if (!Array.isArray(value)) {
                        if (this.contrast.split) {
                            // split field value into separate colors
                            contrasts = value.split(this.contrast.split);
                        } else {
                            // make sure color is in an array
                            contrasts = [value];
                        }
                    }

                    // trim color values and remove too short values
                    contrasts = contrasts.map((color) => color.trim());
                    contrasts = contrasts.filter((color) => color.length > 2);
                }
            }

            return contrasts;
        },

        isWatching() {
            return this.contrast?.type === 'watch' && this.contrast?.field;
        },

        hasChanges() {
            return this.$store.getters['content/hasChanges']()[
                this.contrast.field
            ];
        }
    },

    created() {
        if (this.isWatching && this.hasChanges) {
            this.contrastColors = this.watching;
        }
    },

    watch: {
        watching() {
            this.contrastColors = this.watching;
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
