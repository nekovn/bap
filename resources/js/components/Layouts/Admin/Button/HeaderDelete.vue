<template>
    <span class="btn d-sm-inline-block shadow-lg px-3" aria-label="delete button" role="button">
        <font-awesome-icon icon="trash" class="pe-2"/>
        <span>{{ $t("global.delete") }}</span>
    </span>
</template>

<script>
import {computed, onMounted} from "vue";
import {useI18n} from "vue-i18n";
import {useStore} from "vuex";
import {getAttrFilter} from "../../../../helpers/Flash";
import {handleResponseData} from "../../../../helpers/FormHelper";

export default {
    name: "HeaderDelete",
    props: {
        routerName: {type: String, default: ''}
    },
    setup(props) {
        const {t} = useI18n();
        const store = useStore();
        const {routerName} = props;
        const confirm = computed(() => store.getters.GET_CONFIRM);

        onMounted(() => {
            confirmItem();
            deleteItem();
        });

        /**
         * 項目を確認する
         */
        const confirmItem = () => {
            const idElm = document.getElementById('admin-header');
            const deleteElm = idElm?.querySelector('[aria-label="delete button"]');
            deleteElm?.addEventListener('click', e => {
                e.preventDefault();
                e.stopImmediatePropagation();
                const selectItem = document.querySelectorAll('[aria-label="select item"]:checked');
                const lengths = selectItem.length;
                const arrId = [];
                if (lengths) {
                    for (let i = 0; i < lengths; i++) {
                        arrId.push(selectItem[i].dataset?.id);
                    }
                }
                if (arrId.length) {
                    store.dispatch('setConfirm', {
                        isShow: true,
                        content: t('global.confirm_content', {'attribute': arrId.length}),
                        data: arrId
                    });
                }
            })
        }

        /**
         * データを削除する (confirmからイベントを発火する
         */
        const deleteItem = () => {
            const idElm = document.getElementById('confirm');
            idElm?.addEventListener('change', e => {
                e.preventDefault();
                e.stopImmediatePropagation();
                //通信データ
                let data = getTargetData(`${routerName}`);
                //ルーティング
                const url = route(`${routerName}.delete`);
                //返却されたレスポンスを処理する
                handleResponseData(idElm, {data, url}, 'filterData', '', false);
            })
        }

        /**
         * ターゲットデータ取得
         * @param idElm ID要素
         */
        const getTargetData = (idElm) => {
            //フィルター属性を取得する
            let attrs = getAttrFilter(idElm, true, false);
            const deleteId = confirm.value?.data;
            return {...attrs, deleteId};
        }
    }
}
</script>

<style scoped>

</style>
