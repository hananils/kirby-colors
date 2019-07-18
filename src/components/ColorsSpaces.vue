<template>
    <k-dropdown>
        <k-button
            icon="angle-down"
            class="k-colors-space-button"
            tabindex="-1"
            @click="$refs.dropdown.toggle()"
        />
        <k-dropdown-content ref="dropdown" align="right">
            <k-dropdown-item
                @click="showHex"
                :class="{ 'is-current': space === 'hex' }"
                >HEX</k-dropdown-item
            >
            <k-dropdown-item
                @click="showRgb"
                :class="{ 'is-current': space === 'rgb' }"
                >RGB</k-dropdown-item
            >
            <k-dropdown-item
                @click="showHsl"
                :class="{ 'is-current': space === 'hsl' }"
                >HSL</k-dropdown-item
            >
        </k-dropdown-content>
    </k-dropdown>
</template>

<script>
export default {
    props: {
        space: String
    },
    methods: {
        showHex() {
            this.$emit('change-space', 'hex');
        },
        showRgb() {
            this.$emit('change-space', 'rgb');
        },
        showHsl() {
            this.$emit('change-space', 'hsl');
        }
    }
};
</script>

<style>
.k-colors-field .k-dropdown {
    grid-column-start: 4;
}

.k-colors-field .k-dropdown-item {
    justify-content: flex-end;
    padding-left: 8px;
}

.k-colors-field .k-dropdown-item.is-current::before {
    content: '✓';
    margin-right: 0.5rem;
}

.k-colors-space-button {
    height: 2.25rem;
    padding: 0 12px;
}
</style>
