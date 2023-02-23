<template>
    <!-- Date -->
    <Datepicker :enableTimePicker="false" teleport="#app"
                format="yyyy/MM/dd"
                :select-text="$t('global.select')" :cancel-text="$t('global.close')"
                :placeholder="item.placeholder" :name="name" v-model="data"
                :inputClassName="item.class" :aria-label="name">
    </Datepicker>
    <!-- エラーメッセージ -->
    <span class="form-hint bg-red-lt" :data-message="`${name}`"></span>
</template>

<script>
import {defineAsyncComponent, watch, ref} from "vue";
const Datepicker = defineAsyncComponent(() => import('@vuepic/vue-datepicker'))

export default {
    name: "DateElement",
    components: {Datepicker},
    props: {
        item: {type: Object, default: null},
        name: {type: String, default: null},
        editData: {default: ''},
    },
    setup(props) {
        const data = ref();
        watch([() => props.editData], ([newData]) => {
            data.value = newData;
        });

        return {data};
    }
}
</script>

<style scoped>

</style>
