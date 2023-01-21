<template>
    <span class="btn d-sm-inline-block shadow-lg px-3" aria-label="create button" role="button" @click="handleOpenCreate">
        <font-awesome-icon icon="plus" class="pe-2"/>
        <span>{{ $t("global.created") }}</span>
    </span>
</template>
<script>
import {clearValueInput} from "../../../../helpers/FormHelper";
import {useStore} from "vuex";

export default {
    name: "HeaderCreate",
    props: {
        element: {type: String, default: ''},
    },
    setup(props) {
        const {element} = props;
        const store = useStore();
        //開くイベント
        const handleOpenCreate = (e) => {
            e.preventDefault();
            e.stopImmediatePropagation();
            //開く要素
            const idElm = document.getElementById(element);
            //作成モダール画面を開く
            store.dispatch('setShowCreateModal', true);
            //Inputの値を空白に設定する
            clearValueInput(idElm);
        }
        return {handleOpenCreate}
    }
}
</script>

<style scoped>

</style>
