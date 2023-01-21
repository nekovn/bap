<template>
    <div class='col-xm-12 col-xl-1 card py-2 mx-2 mt-2'>
        <div class='form-group'>
            <label class="form-label card-fieldset" :for="label_name">{{ label_name }}</label>
            <button class='btn w-100 mt-3' :id='label_name' data-status='false'>
                <span :title='label_name' class='pe-1' :class="color_name">{{ span_name }}</span>
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: "ButtonFilter",
    props: {
        label_name: {type: String, default: ''},
        color_name: {type: String, default: ''},
        span_name: {type: String, default: '0'},
    }
}
</script>

<style scoped>

</style>
