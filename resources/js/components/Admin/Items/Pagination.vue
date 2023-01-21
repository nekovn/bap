<template>
    <div class="card-footer fs-3 bd-top-none" v-if="totalPage">
        <div class="flex-center" id="pagination">
            <div class="pagination-icon" @click="firstPage()" aria-label="first-page" role="button">
                <font-awesome-icon icon="backward-fast"/>
            </div>
            <div class="pagination-icon" @click="prevPage()" aria-label="prev-page" role="button">
                <font-awesome-icon icon="backward"/>
            </div>
            <div class="pagination-text" aria-label="current-page" :data-current="GET_ATTRS?.current_page">
                ({{GET_ATTRS?.current_page}}/{{ GET_ATTRS?.totalPage }})
            </div>
            <div class="pagination-icon" @click="nextPage()" aria-label="next-page" role="button">
                <font-awesome-icon icon="forward"/>
            </div>
            <div class="pagination-icon" @click="lastPage()" aria-label="last-page" role="button">
                <font-awesome-icon icon="forward-fast"/>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "../../../store/map-state";
import {computed, ref} from "vue"
import {getAttrFilter} from "../../../helpers/Flash";
import {handleResponseData} from "../../../helpers/FormHelper";

export default {
    name: "Pagination",
    props: {
        router: {type: String, default: ''}
    },
    setup(props) {
        const {router} = props;
        const {GET_ATTRS} = mapGetters();
        //ルーター名
        const routerName = computed(() => router);
        //現在ページ
        const currentPage = computed(() => GET_ATTRS.value?.current_page);
        //合計ページ
        const totalPage = computed(() => GET_ATTRS.value?.totalPage);
        //位置
        const offset = ref(1);
        //初めページへ戻る
        const firstPage = () => {
            if (currentPage.value.toString() !== '1') {
                //位置
                offset.value = 1;
                //API呼び出し
                handlePagination()
            }
        }
        //前のページへ遷移する
        const prevPage = () => {
            if (currentPage.value.toString() !== '1') {
                //位置
                offset.value = parseInt(currentPage.value) - 1;
                //API呼び出し
                handlePagination()
            }
        }
        //次のページへ遷移する
        const nextPage = () => {
            if (GET_ATTRS.value?.current_page.toString() !== totalPage.value.toLocaleString()) {
                //位置
                offset.value = parseInt(currentPage.value) + 1;
                //API呼び出し
                handlePagination()
            }
        }
        //最後のページへ遷移する
        const lastPage = () => {
            if (GET_ATTRS.value?.current_page.toString() !== totalPage.value.toLocaleString()) {
                //位置
                offset.value = parseInt(totalPage.value);
                //API呼び出し
                handlePagination()
            }
        }
        /**
         * API呼び出し
         */
        const handlePagination = () => {
            //ルーティング
            const url = route(`${routerName.value}.filter`);
            //ID要素
            const idElm = document.getElementById(`${routerName.value}`);
            //フィルター属性を取得する
            const attrs = getAttrFilter(`${routerName.value}`, true, true, true, true);
            //通信データ
            const data = {...attrs, offset: offset.value};
            //返却されたレスポンスを処理する
            handleResponseData(idElm, {data, url}, 'filterData', '', false);
        }

        return {GET_ATTRS, totalPage, firstPage, prevPage, nextPage, lastPage}
    }
}
</script>

<style scoped>

</style>
