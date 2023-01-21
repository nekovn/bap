<template>
    <!-- Radio -->
    <div class="form-selectgroup" v-for="(val, index) in item.value?.code_value" :key="index"
         v-if="item.value?.code_value">
        <label class="form-selectgroup-item me-3">
            <input :type="item.type" :name="name" :class="item.class" :value="val.key" :disabled="item.disabled"
                   :required="item.required" :aria-label="name" :checked="editData === val.key">
            <span class="form-selectgroup-label">{{ val.value }}</span>
        </label>
    </div>
    <!-- エラーメッセージ -->
    <span class="form-hint bg-red-lt" :data-message="`${name}`"></span>
    <!-- デフォルト -->
    <input class="d-none" type="radio" :name="name" value="" :checked="!editData">
</template>

<script>
export default {
    name: "RadioElement",
    props: {
        item: {type: Object, default: null},
        name: {type: String, default: null},
        editData: {default: ''},
    }
}
</script>

<style scoped>

</style>
