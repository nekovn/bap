<template>
    <!-- Textarea -->
    <textarea rows="5" :class="item.class" :name="name" :required="item.required" autocomplete="off"
              :placeholder="item.placeholder" :maxlength="item.maxlength" :disabled="item.disabled" :aria-label="name">{{ editData }}
    </textarea>
    <!-- エラーメッセージ -->
    <span class="form-hint bg-red-lt" :data-message="`${name}`"></span>
</template>

<script>
export default {
    name: "TextareaElement",
    props: {
        item: {type: Object, default: null},
        name: {type: String, default: null},
        editData: {default: ''},
    },
}
</script>

<style scoped>

</style>
