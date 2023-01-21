<template>
    <div class="my-3 navbar">
        <AlertMessages className="w-75"/>
        <div class="input-icon">
            <div class="d-flex">
                <span aria-label="search-btn" class="btn-search btn" role="button" @click="searchData">
                    <font-awesome-icon icon="magnifying-glass" class="text-azure"/>
                </span>
                <div>
                    <input type="text" class="form-control ps-3-25" :placeholder="$t('global.search')"
                           aria-label="keyword" role="button" name="keyword" v-model="search">
                    <small class="form-hint" v-if="hint">{{ $t('global.by_column') }}: {{ hint }}</small>
                    <!-- エラーメッセージ -->
                    <span class="form-hint bg-red-lt" data-message="keyword"></span>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {computed, onMounted, ref} from "vue";
import AlertMessages from "../../Layouts/Alert/AlertMessages";
import {Inertia} from "@inertiajs/inertia";
import {handleResponseData} from "../../../helpers/FormHelper";
import {useStore} from "vuex";
import {getAttrFilter} from "../../../helpers/Flash";

export default {
    name: "Search",
    components: {AlertMessages},
    props: {
        searchBy: {type: Array, default: null},
        tHead: {type: Object, default: null},
        router: {type: String, default: ''},
    },
    setup(props) {
        const hint = ref('');
        const search = ref('');
        const {router} = props;
        //ルーター名
        const routerName = computed(() => router);
        const store = useStore();
        onMounted(() => {
            hint.value = searchByText(props.searchBy, props.tHead);
        })
        /**
         * カラムを検索するテキスト
         * @param hint
         * @param thead
         * @return {string}
         */
        const searchByText = (hint, thead) => {
            const lengths = hint.length;
            let text = '';
            if (lengths) {
                for (let i = 0; i < lengths; i++) {
                    if (thead[hint[i]] !== undefined) {
                        text += `${thead[hint[i]]}`;
                        if (i < lengths - 1) text += ', ';
                    }
                }
            }
            return text;
        }
        /**
         * 検索を実行する
         * @param e
         */
        const searchData = (e) => {
            e.preventDefault();
            e.stopImmediatePropagation();
            //ID要素
            const idElm = document.getElementById(`${routerName.value}`);
            //通信データ
            const data = getTargetData(`${routerName.value}`);
            //ルーティング
            const url = route(`${routerName.value}.search`);
            //検索キーワードがある時
            if (search.value) {
                //返却されたレスポンスを処理する
                handleResponseData(idElm, {data, url}, 'filterData', '', false);
            } else {
                //リロードする
                Inertia.get(route(`${routerName.value}.index`));
                //トーストを削除する
                store.dispatch('setToast');
            }
        }

        /**
         * ターゲットデータ取得
         * @param idElm ID要素
         */
        const getTargetData = (idElm) => {
            return getAttrFilter(idElm, true, true, true, true);
        }

        return {hint, search, searchData}
    },
}
</script>

<style scoped>

</style>
