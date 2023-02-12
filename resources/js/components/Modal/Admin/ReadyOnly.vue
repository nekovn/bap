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
                            <div class="text-break ps-1" v-html="showValue(editData[index])" v-if="index !== 'image'"></div>
                            <div class="text-break ps-1 row" v-if="index === 'image'">
                                <image-light-box :editData="editData[index]" @show="show"/>
                            </div>
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
    <!-- 画像表示 -->
    <vue-easy-lightbox
        :visible="visibleRef"
        :imgs="imgsRef"
        :index="indexRef"
        @hide="onHide"
    />
</template>

<script>
import VueEasyLightbox, { useEasyLightbox } from 'vue-easy-lightbox'
import 'vue-easy-lightbox/external-css/vue-easy-lightbox.css'
import {useStore} from "vuex";
import {computed} from "vue";
import {mapGetters} from "../../../store/map-state";
import {importComponentModalArea, importComponentModalForm} from "../../../composables/Admin/useImportFile";
import {showListContent} from "../../../helpers/Flash";
const {ModalFooter, ModalEmpty, ModalHead} = importComponentModalArea();
const {ImageLightBox} = importComponentModalForm();
export default {
    name: "ReadyOnly",
    components: {ImageLightBox, ModalHead, ModalEmpty, ModalFooter, VueEasyLightbox},
    props: {
        editData: {default: null}
    },
    setup() {
        const store = useStore();
        const {GET_SHOW_READY_MODAL} = mapGetters();
        //Thead取得
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
            } else if (typeof value === 'object' && value?.length) {
                return showListContent(value, false);
            } else {
                return '';
            }
        }
        //ライトボックス
        const {
            //methods
            onHide,
            // refs
            visibleRef, indexRef, imgsRef
        } = useEasyLightbox();
        //画像表示イベント
        const show = (data) => {
            indexRef.value = data.index
            visibleRef.value = true
            imgsRef.value = data.image
        }
        return {theadData, showValue, GET_SHOW_READY_MODAL, visibleRef, indexRef, imgsRef, show, onHide}
    }
}
</script>

<style scoped>

</style>
