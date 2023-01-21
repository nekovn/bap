<template>
    <!-- 閉じるボタン -->
    <span class="h4" aria-label="modal_close" role="button" data-bs-dismiss="modal_close" v-if="btn === 'close'">
        {{ $t('global.close') }}
    </span>
</template>

<script>
import {onMounted} from "vue";
import {useStore} from "vuex";
export default {
    name: "Close",
    props: {
        element: {type: String, default: ''},
        btn: {type: String, default: ''},
    },
    setup(props) {
        const {element} = props;
        const store = useStore();
        //閉じるイベント
        onMounted(() => {
            //閉じる要素
            const idElm = document.getElementById(element);
            const closeModal = idElm?.querySelectorAll('[data-bs-dismiss="modal_close"]');
            for (let i = 0; i < closeModal.length; i++) {
                closeModal[i].addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    //Modalを閉じる
                    const actionName = idElm.dataset.action;
                    store.dispatch(actionName);
                    //トースト非表示
                    store.dispatch('setToast')
                })
            }
        })
    }
}
</script>

<style scoped>

</style>
