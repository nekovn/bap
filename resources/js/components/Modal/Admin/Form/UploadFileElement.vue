<template>
    <input type="file" :name="name" :class="item.class" :accept="item.type" :disabled="item.disabled"
           :value="editData" :placeholder="item.placeholder" :required="item.required" multiple>
</template>

<script>
export default {
    name: "UploadFileElement",
    props: {
        item: {type: Object, default: null},
        name: {type: String, default: null},
        element: {type: String, default: ''},
        editData: {default: ''},
    },
}
</script>

<style scoped>

</style>
