<template>
    <div class="modal modal-blur fade show d-block" id="modal-ready" tabindex="-1" aria-modal="true" role="dialog"
         v-if="GET_SHOW_READY_MODAL && editData" data-action="setShowReadyModal">>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <!-- ヘッダー -->
                <modal-head :title="$t('global.see_detail')"/>
                <!-- コンテンツ -->
                <div class="modal-body row" v-if="editData">
                    <template v-for="(thead,index) in theadData" :key="index">
                        <div class="col-6 mb-3" v-if="index !== 'id' && index !== 'button'">
                            <div class="label-bg">{{ thead }}</div>
                            <div class="text-break ps-1" v-html="showValue(editData[index])"></div>
                        </div>
                    </template>
                </div>
                <!-- データがない時 -->
                <modal-empty :data="editData && theadData"/>
                <!-- フッター -->
                <modal-footer element="modal-ready" btn="close"/>
            </div>
        </div>
    </div>
</template>

<script>
import {useStore} from "vuex";
import {computed} from "vue";
import {mapGetters} from "../../../store/map-state";
import {importComponentModalArea} from "../../../composables/Admin/useImportFile";
import {showListContent} from "../../../helpers/Flash";

const {ModalFooter, ModalEmpty, ModalHead} = importComponentModalArea();
export default {
    name: "ReadyOnly",
    components: {ModalHead, ModalEmpty, ModalFooter},
    props: {
        editData: {default: null}
    },
    setup() {
        const store = useStore();
        const {GET_SHOW_READY_MODAL} = mapGetters();
        const theadData = computed(() => {
            return store.getters.GET_THEAD_DATA
        });

        /**
         * 値表示する
         * @param value
         * @return string
         */
        const showValue = (value) => {
            if ((typeof value === 'string' || typeof value === 'number') && value) {
                return value;
            } else if (typeof value === 'object' && value && value['value']) {
                return value['value'];
            } else if (typeof value === 'object' && value.length) {
                return showListContent(value, false);
            } else {
                return '';
            }
        }

        return {theadData, showValue, GET_SHOW_READY_MODAL}
    }
}
</script>

<style scoped>

</style>
