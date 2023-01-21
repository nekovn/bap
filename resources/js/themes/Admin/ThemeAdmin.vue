<template>
    <div class="page">
        <!-- Sidebar -->
        <Navbar/>
        <div class="page-wrapper">
            <!-- Page header -->
            <Header :title="title" :isActions="isActions" :router="router"/>
            <!-- Page body -->
            <slot/>
            <!-- Page Footer -->
            <Footer/>
        </div>
        <!-- ロードアイコン -->
        <spinner-element/>
        <!-- トースト -->
        <toast-element/>
    </div>
</template>
<script>
import {Inertia} from "@inertiajs/inertia";
import {useStore} from "vuex";
import {importComponentTheme} from "../../composables/Admin/useImportFile";
const {Footer, Header, Navbar, ToastElement, SpinnerElement} = importComponentTheme();
export default {
    name: "ThemeAdmin",
    components: {SpinnerElement, ToastElement, Header, Footer, Navbar},
    props: {
        title: {type: String, default: ''},
        isActions: {type: Object, default: []},
        router: {type: String, default: ''}
    },
    setup() {
        const store = useStore();
        //Eventを開始
        Inertia.on('start', (event) => {
            //ロードアイコンを開始する
            store.commit('SET_LOADING', true);
        });
        //Eventを終了
        Inertia.on('finish', (event) => {
            //ロードアイコンを停止する
            store.commit('SET_LOADING', false);
        })
    }
}
</script>

<style scoped>

</style>
