<template>
    <div class="page-header d-print-none head-static border-bottom" id="admin-header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title">
                        {{ title }}
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <!-- 削除ボタン -->
                        <header-delete v-if="isActions.delete" :routerName="routerName"/>
                        <!-- 作成ボタン -->
                        <header-create v-if="isActions.create" element="modal-create" :routerName="routerName"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {computed} from "vue";
import {importComponentLayout} from "../../../composables/Admin/useImportFile";
const {HeaderDelete, HeaderCreate} = importComponentLayout();

export default {
    name: "Header",
    components: {HeaderCreate, HeaderDelete},
    props: {
        title: {type: String, default: ''},
        isActions: {type: Object, default: []},
        router: {type: String, default: ''}
    },
    setup(props) {
        const {router} = props;
        //ルーター名
        const routerName = computed(() => router);
        return {routerName};
    }
}
</script>

<style scoped>

</style>
