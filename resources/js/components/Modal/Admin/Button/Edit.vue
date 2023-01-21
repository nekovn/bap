<template>
    <!-- 編集ボタン -->
    <button aria-label="modal_edit" class="btn" role="button" data-bs-dismiss="modal_submit"
            v-if="btn === 'edit'" @click="handleEdit($event, oldData)">
        <font-awesome-icon icon="pen-to-square" class="icon"/>
        {{ $t('global.edit') }}
    </button>
</template>

<script>
import {computed} from "vue";
import {getSelectedValue, handleResponseData} from "../../../../helpers/FormHelper";
import {compareData, getAttrFilter} from "../../../../helpers/Flash";
import {useStore} from "vuex";
import {useI18n} from "vue-i18n";

export default {
    name: "Edit",
    props: {
        element: {type: String, default: ''},
        btn: {type: String, default: ''},
        router: {type: String, default: ''},
        oldData: {default: null}
    },
    setup(props) {
        const {element, router} = props;
        const store = useStore();
        const {t} = useI18n();
        //ルーター名
        const routerName = computed(() => router);
        //編集イベント
        const handleEdit = (e, oldData) => {
            e.preventDefault();
            e.stopImmediatePropagation();
            //画面要素
            const idElm = document.getElementById(element);
            //入力されたデータ取得
            const newData = getSelectedValue(idElm);
            //変更済データ取得
            let updatedData = compareData(newData, oldData);
            const objectKeys = Object.keys(updatedData);
            //変更済データがない時、msg出る
            if (!objectKeys.length) {
                //トーストを設定する
                store.commit('SET_TOAST', {
                    title: t('global.error'), content: t('global.data_not_change'), class: 'show bg-danger',
                });
            } else {
                const data = getTargetData(newData, updatedData);
                //ルーティング
                const url = route(`${routerName.value}.edit`);
                //返却されたレスポンスを処理する
                handleResponseData(idElm, {data, url}, 'editData', 'setShowEditModal');
            }
        }

        /**
         * ターゲットデータ取得
         * @param newData 入力されたデータ取得
         * @param updatedData 変更済データ
         */
        const getTargetData = (newData, updatedData) => {
            //idを追加する
            const id = newData['id'];
            //uuidを追加する
            const uuid = newData['uuid'];
            //フィルター属性を取得する
            let attrs = getAttrFilter(`${routerName.value}`, true, true);
            const options = {
                id,
                uuid,
                ...attrs,
            }
            //変更済データ取得
            return {...updatedData, ...options};
        }

        return {handleEdit}
    }
}
</script>

<style scoped>

</style>
