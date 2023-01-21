<template>
    <div class="modal-body" v-if="!data">{{ $t('global.data_empty') }}</div>
</template>

<script>
import {onMounted} from "vue";
import {showSelectedOption} from "../../../../helpers/FormHelper";

export default {
    name: "ModalEmpty",
    props: {
        data: {default: null},
        editData: {default: ''},
        element: {type: String, default: ''},
    },
    setup(props) {
        const {element, editData} = props;
        onMounted(() => {
            if (editData) {
                //画面要素
                const idElm = document.getElementById(element);
                showSelectedOption(idElm, editData);
            }
        })
    }
}
</script>

<style scoped>

</style>
