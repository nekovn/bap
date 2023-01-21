<template>
    <div class="modal modal-blur fade" :class="{'d-block show': confirm.isShow}" tabindex="-1" id="confirm">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal_close" aria-label="Close"></button>
                <div class="modal-status bg-danger"></div>
                <div class="modal-body text-center py-4">
                    <font-awesome-icon icon="triangle-exclamation" class="icon mb-2 text-danger icon-lg"/>
                    <h3>{{ $t('global.confirm') }}</h3>
                    <div class="text-muted">{{ confirm.content }}</div>
                </div>
                <div class="modal-footer">
                    <div class="w-100">
                        <div class="row">
                            <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal_close">
                                {{ $t('global.no') }}
                            </a></div>
                            <div class="col"><a href="#" class="btn btn-danger w-100" data-bs-dismiss="modal_confirmed">
                                {{ $t('global.yes') }}
                            </a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {computed, onMounted} from "vue";
import {useStore} from "vuex";

export default {
    name: "Confirm",
    setup() {
        const store = useStore();
        const confirm = computed(() => store.getters.GET_CONFIRM);
        onMounted(() => {
            //Modal要素
            const idElm = document.getElementById('confirm');
            //閉じるイベント
            closeModal(idElm);
            //Confirmedイベント
            confirmedEvent(idElm);
        })


        const closeModal = (idElm) => {
            const closeModalElm = idElm.querySelectorAll('[data-bs-dismiss="modal_close"]');
            for (let i = 0; i < closeModalElm.length; i++) {
                closeModalElm[i].addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    //すべて選択の要素
                    const selectAll = document.querySelector('[aria-label="select all"]');
                    //changeイベントを呼び出し
                    const event = new Event('change');
                    //すべて選択された項目：OFFにする
                    selectAll.checked = false;
                    selectAll.dispatchEvent(event);
                    //modal非表示
                    store.state.confirm.isShow = false;
                    idElm.classList.remove(...['show', 'd-block']);
                })
            }
        }

        const confirmedEvent = (idElm) => {
            const confirmedModalElm = idElm.querySelector('[data-bs-dismiss="modal_confirmed"]');
            confirmedModalElm.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopImmediatePropagation();
                //Confirm要素
                const idElm = document.getElementById('confirm');
                //すべて選択の要素
                const selectAll = document.querySelector('[aria-label="select all"]');
                //changeイベントを呼び出し
                const event = new Event('change');
                //選択イベント発火
                selectAll.checked = false;
                selectAll.dispatchEvent(event);
                //削除イベント発火
                idElm.dispatchEvent(event);
                //modal非表示
                store.state.confirm.isShow = false;
                idElm.classList.remove(...['show', 'd-block']);
            })
        }


        return {confirm};
    }
}
</script>

<style scoped>

</style>
