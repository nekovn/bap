<template>
    <!-- Hidden Input -->
    <input type="hidden" :name="name" :value="editData || item.value">
</template>

<script>
export default {
    name: "HiddenElement",
    props: {
        item: {type: Object, default: null},
        name: {type: String, default: null},
        editData: {default: ''},
    },
}
</script>

<style scoped>

</style>
