<template>
    <!-- checkbox -->
    <div :class="item.class" v-for="(val, index) in item.value?.code_value" :key="index"
         v-if="item.value?.code_value">
        <label class="form-selectgroup-item me-3">
            <input :type="item.type" :name="name" class="form-check-input" :value="val.key" :disabled="item.disabled"
                   :required="item.required" :aria-label="name" :checked="editData ?
                   editData?.find(editVal => editVal.key === val.key) : false">
            <span class="form-check-label">{{ val.value }}</span>
        </label>
    </div>
</template>

<script>
export default {
    name: "CheckboxInputElement",
    props: {
        item: {type: Object, default: null},
        name: {type: String, default: null},
        editData: {default: null},
    },
}
</script>
