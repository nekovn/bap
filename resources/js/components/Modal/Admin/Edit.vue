<template>
    <div class="modal modal-blur fade show d-block" id="modal-edit" tabindex="-1" aria-modal="true" role="dialog"
         v-if="GET_SHOW_EDIT_MODAL && editData" data-action="setShowEditModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <!-- ヘッダー -->
                <modal-head :title="$t('global.edit_data')"/>
                <!-- コンテンツ -->
                <div class="modal-body" v-if="formInput">
                    <form class="row mb-3">
                        <template v-for="(item, index) in formInput" :key="index">
                            <div class="col-6 mb-2" v-if="item.isEdit && item.type !== 'hidden'">
                                <form-group :label="item.title" :required="item.required">
                                    <input-element v-if="item.form?.includes('input')" :item="item" :name="index"
                                                   element="modal-edit" :editData="editData[index]"/>
                                    <select-element v-if="item.form?.includes('select')" :item="item" :name="index"
                                                    element="modal-edit"/>
                                    <date-element v-if="item.form?.includes('date')" :item="item" :name="index"
                                                  :editData="editData[index]"/>
                                    <textarea-element v-if="item.form?.includes('textarea')" :item="item"
                                                      :name="index" :editData="editData[index]"/>
                                    <radio-element v-if="item.form?.includes('radio')" :item="item" :name="index"
                                                   :editData="editData[index]?.key"/>
                                    <upload-file-element v-if="item.form?.includes('upload')" :item="item" :name="index"
                                                         element="modal-edit" :editData="editData[index]"/>
                                </form-group>
                            </div>
                            <hidden-element :item="item" :name="index" :editData="editData[index]"
                                            v-if="item.isEdit && item.type === 'hidden'"/>
                        </template>
                    </form>
                </div>
                <!-- データがない時 -->
                <modal-empty element="modal-edit" :data="formInput" :editData="editData"/>
                <!-- フッター -->
                <modal-footer element="modal-edit" btn="edit" :router="router" @getNewTbody="getNewTbody"
                              :data="formInput" :oldData="editData"/>
            </div>
        </div>
    </div>
</template>
<script>
import {mapGetters} from "../../../store/map-state";
import {importComponentModalForm, importComponentModalArea} from "../../../composables/Admin/useImportFile";

const {
    FormGroup,
    InputElement,
    SelectElement,
    TextareaElement,
    RadioElement,
    DateElement,
    HiddenElement,
    UploadFileElement
} = importComponentModalForm();
const {ModalFooter, ModalEmpty, ModalHead} = importComponentModalArea();
export default {
    name: "Edit",
    components: {
        UploadFileElement,
        HiddenElement,
        ModalHead,
        ModalEmpty,
        ModalFooter,
        DateElement,
        RadioElement,
        TextareaElement,
        SelectElement,
        InputElement,
        FormGroup
    },
    props: {
        router: {type: String, default: ''},
        editData: {default: null}
    },
    emits: ['getNewTbody'],
    setup(_, {emit}) {
        const {GET_ATTRS, GET_SHOW_EDIT_MODAL} = mapGetters();
        const {formInput} = GET_ATTRS.value;
        //正常の時、最新のデータを更新する
        const getNewTbody = (data) => {
            emit('getNewTbody', data);
        }
        return {formInput, getNewTbody, GET_SHOW_EDIT_MODAL}
    }
}
</script>

<style scoped>

</style>
