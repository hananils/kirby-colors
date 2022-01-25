<script>
export default {
    props: {
        value: String
    }
}
</script>

<template>
    <span class="k-colors-structure-preview" :style="{ backgroundColor: value }"></span>
</template>

<style>
    .k-colors-structure-preview {
        display: block;
        width: 1.5rem;
        height: 1.5rem;
        margin: 0 .75rem;
    }
</style>