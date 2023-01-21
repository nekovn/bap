<template>
    <div class='col-xm-12 col-xl-4 card py-2 mt-2 mx-2'>
        <div class='form-group'>
            <label class="form-label card-fieldset">{{ $t('global.time') }}</label>
            <div class="flex-center mt-3">
                <Datepicker v-model="date_start" :enableTimePicker="false" teleport="#app"
                            format="yyyy/MM/dd"
                            :select-text="$t('global.select')" :cancel-text="$t('global.close')"
                            :placeholder="$t('global.start')" :disabled="isDisabledStart" name="date_start"
                            inputClassName="date_start" @update:modelValue="handleDateStart"></Datepicker>
                <div class="form-label separator-time mx-2">~</div>
                <Datepicker v-model="date_end" :enableTimePicker="false" teleport="#app"
                            format="yyyy/MM/dd"
                            :select-text="$t('global.select')" :cancel-text="$t('global.close')"
                            :placeholder="$t('global.end')" :disabled="isDisabledEnd" name="date_end"
                            inputClassName="date_end" @update:modelValue="handleDateEnd"></Datepicker>
            </div>
        </div>
    </div>
</template>
<script>
import {computed, ref, defineAsyncComponent} from "vue";
import {handleResponseData} from "../../../../helpers/FormHelper";
import {getAttrFilter} from "../../../../helpers/Flash";
const Datepicker = defineAsyncComponent(() => import('@vuepic/vue-datepicker'));
import '@vuepic/vue-datepicker/dist/main.css';
export default {
    name: "Time",
    components: {Datepicker},
    props: {
        router: {type: String, default: ''}
    },
    setup(props) {
        const {router} = props;
        //ルーター名
        const routerName = computed(() => router);
        //連続禁止
        const isDisabledStart = ref(false);
        const isDisabledEnd = ref(true);
        //開始時間
        const date_start = ref(null);
        //終了時間
        const date_end = ref(null);
        /**
         * 開始時間を処理する
         * @param modelValue
         */
        const handleDateStart = (modelValue) => {
            if (modelValue) {
                isDisabledEnd.value = false;
                if (date_end.value) {
                    sendData();
                }
            } else {
                date_end.value = null;
                isDisabledEnd.value = true;
            }
        }
        /**
         * 終了時間を処理する
         * @param modelValue
         */
        const handleDateEnd = (modelValue) => {
            if (!modelValue) {
                date_start.value = null;
                isDisabledEnd.value = true;
            } else {
                if (date_start.value) {
                    sendData();
                }
            }
        }
        /**
         * データを通信する
         */
        const sendData = () => {
            //ID要素
            const idElm = document.getElementById(`${routerName.value}`);
            //検索キーワード
            const searchElm = idElm.querySelector('[aria-label="keyword"]');
            searchElm.value = '';
            //通信データ
            const data = getTargetData(`${routerName.value}`);
            //ルーティング
            const url = route(`${routerName.value}.filter`);
            //返却されたレスポンスを処理する
            handleResponseData(idElm, {data, url}, 'filterData', '', false);
        }

        /**
         * ターゲットデータ取得
         * @param idElm ID要素
         */
        const getTargetData = (idElm) => {
            //フィルター属性を取得する
            let attrs = getAttrFilter(idElm, true, false);
            //開始時間
            const dateStart = date_start.value;
            //終了時間
            const dateEnd = date_end.value;
            const options = {dateStart, dateEnd};
            return {...attrs, ...options};
        }

        return {isDisabledStart, isDisabledEnd, date_start, date_end, handleDateStart, handleDateEnd}
    }
}
</script>

<style scoped>

</style>
