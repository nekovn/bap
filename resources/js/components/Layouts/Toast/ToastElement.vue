<template>
    <div class="toast toast-msg" :class="GET_TOAST.class" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body navbar">
            <div class="text-white" aria-label="alert-title" v-html="GET_TOAST.content"></div>
            <button type="button" class="ms-2 btn-close" aria-label="Close" @click="closeToast"></button>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "../../../store/map-state";
import {useStore} from "vuex";
export default {
    name: "ToastElement",
    setup() {
        const store = useStore();
        const {GET_TOAST} = mapGetters();
        const closeToast = (e) => {
            e.preventDefault();
            e.stopImmediatePropagation();
            store.dispatch('setToast');
        }
        return {GET_TOAST, closeToast};
    }
}
</script>

<style scoped>

</style>
