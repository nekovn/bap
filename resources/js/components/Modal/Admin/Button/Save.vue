<template>
    <!-- 保存ボタン -->
    <button aria-label="modal_close" class="btn" role="button" data-bs-dismiss="modal_create"
            v-if="btn === 'save'" @click="handleSave">
        <font-awesome-icon icon="floppy-disk" class="icon"/>
        {{ $t('global.save') }}
    </button>
</template>

<script>
import {getSelectedValue, handleResponseData} from "../../../../helpers/FormHelper";
import {computed} from "vue";
import {getAttrFilter} from "../../../../helpers/Flash";

export default {
    name: "Save",
    props: {
        element: {type: String, default: ''},
        btn: {type: String, default: ''},
        router: {type: String, default: ''},
    },
    setup(props) {
        const {element, router} = props;
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
