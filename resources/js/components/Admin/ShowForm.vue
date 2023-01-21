<template>
    <div class="container-xl" id="admin-body">
        <!--   Search   -->
        <Search :searchBy="searchBy" :tHead="tHead" :router="router"/>
        <!--   Filter   -->
        <div class="row">
            <div class="row col-12">
                <!--   Show page   -->
                <ShowPage v-if="filterList.includes('show')" :showPage="showPage" :router="router"/>
                <!--   Reply  -->
                <ButtonFilter :label_name="$t('global.reply')" span_name="0" color_name="bg-azure-lt" v-if="filterList.includes('reply')"/>
                <!--   No Reply  -->
                <ButtonFilter :label_name="$t('global.no_reply')" span_name="0" color_name="bg-red-lt" v-if="filterList.includes('no_reply')"/>
                <!--   Sort  -->
                <Sort v-if="filterList.includes('sort')"/>
                <!--   Time  -->
                <Time v-if="filterList.includes('time')" :router="router"/>
            </div>
        </div>
        <!--   Table   -->
        <div class="card my-5">
            <div class="card-body">
                <div class="text-muted fs-1 card-fieldset top-020">{{ $t('global.list') }}</div>
                <div class="my-4">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table text-nowrap table-light">
                                <!--   Thead   -->
                                <Thead :tHead="tHead"/>
                                <!--   Tbody   -->
                                <Tbody :tHead="tHead" :tBody="tBody" @editData="getEditData"/>
                            </table>
                        </div>
                        <!--   Pagination   -->
                        <Pagination v-if="tBody?.length" :router="router" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {computed} from "vue";
import {importComponentItem} from "../../composables/Admin/useImportFile";
const {Search, Thead, Tbody, Pagination, Sort, Time, ShowPage, ButtonFilter} = importComponentItem();
export default {
    name: "ShowForm",
    props: {
        tHead: {type: Object, default: null},
        filter: {type: String, default: null},
        showPage: {type: String, default: null},
        tBody: {type: Object, default: null},
        searchBy: {type: Array, default: null},
        router: {type: String, default: ''}
    },
    components: {ButtonFilter, Time, Sort, ShowPage, Search, Thead, Tbody, Pagination},
    emits: ['editData'],
    setup(props, {emit}) {
        const {filter} = props;
        const filterList = computed(() => {
            return filter.split(',');
        });
        const getEditData = (data) => {
            emit('editData', data);
        }
        return {filterList, getEditData}
    }
}
</script>

<style scoped>

</style>
