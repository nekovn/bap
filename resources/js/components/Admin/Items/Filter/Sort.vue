<template>
    <div class='col-xm-12 col-xl-2 card py-2 mx-2 mt-2'>
        <div class='form-group'>
            <label class="form-label card-fieldset" for="sort">{{ $t('global.sort') }}</label>
            <select class="form-select mt-3" id="sort" v-model="sortSelected" @change="changeSort">
                <option value="desc">{{ $t('global.desc') }}</option>
                <option value="asc">{{ $t('global.asc') }}</option>
            </select>
        </div>
    </div>
</template>

<script>
import {ref} from "vue";
import {useStore} from "vuex";

export default {
    name: "Sort",
    setup() {
        const store = useStore();
        //選択値
        const sortSelected = ref('asc');
        /**
         * 並び順を変更する
         * @param e
         */
        const changeSort = (e) => {
            e.preventDefault();
            e.stopImmediatePropagation();
            const sort = sortSelected.value;
            //返却されたレスポンスを処理する
            store.dispatch('sortData', sort).then(res => {
                const responseData = res?.data;
                //正常の時
                if (res?.result && responseData?.length) {
                    //最新のデータを更新する
                    store.dispatch('setTbodyData', data);
                }
            });
        }

        return {sortSelected, changeSort}
    }
}
</script>

<style scoped>

</style>
