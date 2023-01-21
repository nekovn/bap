<template>
    <div class='col-xm-12 col-xl-2 card py-2 mx-2 mt-2'>
        <div class='form-group'>
            <label class="form-label card-fieldset" for="show-page">
                {{$t('global.show') }}
            </label>
            <select class="form-select mt-3" id="show-page" v-model="selectVal" @change="changePage">
                <option v-for="(item,index) in showPageList" :key="index" :value="item">{{item}}/{{$t('global.page')}}</option>
            </select>
        </div>
    </div>
</template>

<script>
import {computed, ref} from "vue";
import {handleResponseData} from "../../../../helpers/FormHelper";
import {getAttrFilter} from "../../../../helpers/Flash";

export default {
    name: "ShowPage",
    props: {
        showPage: {type: String, default: null},
        router: {type: String, default: ''}
    },
    setup(props) {
        const {showPage, router} = props;
        //ページのリストを表示する
        const showPageList = computed(() => showPage.split(','));
        //選択値
        const selectVal =  ref('10');
        //ルーター名
        const routerName = computed(() => router);
        /**
         * ページを変更する
         * @param e
         */
        const changePage = (e) => {
            e.preventDefault();
            e.stopImmediatePropagation();
            //ID要素
            const idElm = document.getElementById(`${routerName.value}`);
            //通信データ
            const data = getAttrFilter(`${routerName.value}`, true, false);
            //ルーティング
            const url = route(`${routerName.value}.filter`);
            //返却されたレスポンスを処理する
            handleResponseData(idElm, {data, url}, 'filterData', '', false);
        }

        return {selectVal, showPageList, changePage}
    }
}
</script>

<style scoped>

</style>
