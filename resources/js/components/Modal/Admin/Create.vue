<template>
    <div class="modal modal-blur fade show d-block" id="modal-create" tabindex="-1"
         aria-modal="true" role="dialog" v-if="GET_SHOW_CREATE_MODAL && formInput"  data-action="setShowCreateModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <!-- ヘッダー -->
                <modal-head :title="`${$t('global.create_data')}`"/>
                <!-- コンテンツ -->
                <div class="modal-body" v-if="formInput">
                    <form class="row mb-3">
                        <template v-for="(item, index) in formInput" :key="index">
                            <div class="col-6 mb-2" v-if="item.isCreate && item.type !== 'hidden'">
                                <form-group :label="item.title" :required="item.required" :type="item.type">
                                    <input-element v-if="item.form?.includes('input')" :item="item" :name="index"
                                                   element="modal-create"/>
                                    <select-element v-if="item.form?.includes('select')" :item="item" :name="index"
                                                    element="modal-create"/>
                                    <date-element v-if="item.form?.includes('date')" :item="item" :name="index"/>
                                    <textarea-element v-if="item.form?.includes('textarea')" :item="item"
                                                      :name="index"/>
                                    <radio-element v-if="item.form?.includes('radio')" :item="item" :name="index"/>
                                </form-group>
                            </div>
                            <hidden-element :item="item" :name="index" v-if="item.type === 'hidden'"/>
                        </template>
                    </form>
                </div>
                <!-- データがない時 -->
                <modal-empty :data="formInput"/>
                <!-- フッター -->
                <modal-footer element="modal-create" btn="save" :router="router" :data="formInput"/>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "../../../store/map-state";
import {importComponentModalForm, importComponentModalArea} from "../../../composables/Admin/useImportFile";
const {FormGroup, InputElement, SelectElement, TextareaElement, RadioElement, DateElement, HiddenElement} = importComponentModalForm();
const {ModalFooter, ModalEmpty, ModalHead} = importComponentModalArea();

export default {
    name: "Create",
    components: {
        HiddenElement,
        ModalHead,
        ModalEmpty,
        ModalFooter, DateElement, RadioElement, TextareaElement, SelectElement, InputElement, FormGroup
    },
    props: {
        router: {type: String, default: ''}
    },
    setup(_, {emit}) {
        const {GET_ATTRS, GET_SHOW_CREATE_MODAL} = mapGetters();
        const {formInput} = GET_ATTRS.value;
        return {GET_SHOW_CREATE_MODAL, formInput}
    }
}
</script>

<style scoped>

</style>
