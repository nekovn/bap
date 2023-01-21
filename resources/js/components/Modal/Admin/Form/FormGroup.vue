<template>
    <div>
        <!-- ラベル -->
        <div :class="{'required': required, 'label-bg': true}">{{ label || '' }}</div>
        <div class="text-break mt-2" aria-label="parent">
            <slot/>
        </div>
    </div>
</template>

<script>
export default {
    name: "FormGroup",
    props: {
        required: {type: Boolean, default: false},
        label: {type: String, default: ''},
        type: {type: String, default: ''},
    }
}
</script>

<style scoped>

</style>
