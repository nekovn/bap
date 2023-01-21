<template>
    <!-- Date -->
    <Datepicker :enableTimePicker="false" teleport="#app"
                format="yyyy/MM/dd"
                :select-text="$t('global.select')" :cancel-text="$t('global.close')"
                :placeholder="item.placeholder" :name="name" v-model="editData"
                :inputClassName="item.class" :aria-label="name">
    </Datepicker>
    <!-- エラーメッセージ -->
    <span class="form-hint bg-red-lt" :data-message="`${name}`"></span>
</template>

<script>
import {defineAsyncComponent} from "vue";
const Datepicker = defineAsyncComponent(() => import('@vuepic/vue-datepicker'))

export default {
    name: "DateElement",
    components: {Datepicker},
    props: {
        item: {type: Object, default: null},
        name: {type: String, default: null},
        editData: {default: ''},
    }
}
</script>

<style scoped>

</style>
