<template>
    <!-- Error   -->
    <div class="alert alert-danger navbar" :class="className" v-if="GET_ALERT.errors">
        <div>
            <ul>
                <li v-for="(item, index) in GET_ALERT.errors" :key="index" v-html="item"></li>
            </ul>
        </div>
        <div><button type="button" class="btn-close" data-bs-dismiss="alert_close" aria-label="Close"></button></div>
    </div>
    <!-- Success   -->
    <div class="alert alert-success navbar" :class="className" v-else-if="GET_ALERT.success">
        <div v-html="GET_ALERT.success"></div>
        <div><button type="button" class="btn-close" data-bs-dismiss="alert_close" aria-label="Close"></button></div>
    </div>
    <div v-else></div>
</template>

<script>
import {onUpdated} from "vue";
import {useStore} from "vuex";
import {mapGetters} from "../../../store/map-state";

export default {
    name: "AlertMessages",
    props: {
        className: {type: String, default: ''},
    },
    setup() {
        const store = useStore();
        const {GET_ALERT} = mapGetters();

        onUpdated(() => {
            closeAlert();
        })

        /**
         * alert非表示
         */
        const closeAlert = () => {
            const closeAlertElm = document.querySelector('[data-bs-dismiss="alert_close"]');
            closeAlertElm?.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopImmediatePropagation();
                store.dispatch('setAlert');
            })
        }
        return {GET_ALERT}
    }
}
</script>

<style scoped>

</style>
