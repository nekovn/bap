<template>
    <!-- 保存ボタン -->
    <button aria-label="modal_close" class="btn" role="button" data-bs-dismiss="modal_create"
            v-if="btn === 'save'" @click="handleSave">
        <font-awesome-icon icon="floppy-disk" class="icon"/>
        {{ $t('global.save') }}
    </button>
</template>

<script>
import {getSelectedValue, getUploadFileImage, handleResponseData} from "../../../../helpers/FormHelper";
import {computed} from "vue";
import {getAttrFilter} from "../../../../helpers/Flash";
import {useStore} from "vuex";

export default {
    name: "Save",
    props: {
        element: {type: String, default: ''},
        btn: {type: String, default: ''},
        router: {type: String, default: ''},
    },
    setup(props) {
        const {element, router} = props;
        const store = useStore();
        //ルーター名
        const routerName = computed(() => router);
        //保存イベント
        const handleSave = (e) => {
            e.preventDefault();
            e.stopImmediatePropagation();
            //画面要素
            const idElm = document.getElementById(element);
            //入力されたデータ
            let data = getSelectedValue(idElm);
            //フィルター属性を取得する
            let attrs = getAttrFilter(`${routerName.value}`, true, true);
            data = {...data, ...attrs};
            //追加済ファイル
            const addedData = store.getters.GET_LIST_IMAGE.filter(item => item?.isNewFile);
            if (addedData.length) {
                //追加済画像ファイル
                const addFile = getUploadFileImage(addedData);
                data = {...data, ...{addFile}}
            }
            //ルーティング
            const url = route(`${routerName.value}.create`);
            //返却されたレスポンスを処理する
            handleResponseData(idElm, {data, url}, 'createData', 'setShowCreateModal');
        }

        return {handleSave}
    }
}
</script>

<style scoped>

</style>
