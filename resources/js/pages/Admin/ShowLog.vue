<template>
    <div class="layout-fluid theme-light">
        <head-tag :title="title" :description="description" :canonical="canonical"/>
        <theme-admin :title="title" :isActions="attrsDecode?.isActions" :router="attrsDecode?.router">
            <div class="page-body" :id="attrsDecode?.router">
                <ShowForm :tHead="attrsDecode?.tHead" :searchBy="attrsDecode?.searchBy" :tBody="dataTbody?.data"
                          :filter="attrsDecode?.filter"
                          :showPage="attrsDecode?.showPage" :router="attrsDecode?.router" @editData="getEditData"/>
            </div>
        </theme-admin>
    </div>
    <teleport to="body">
        <ready-only :editData="editData"/>
        <Confirm/>
    </teleport>
</template>
<script>
import {importComponentPage} from "../../composables/Admin/useImportFile";
const {Confirm, ReadyOnly, ShowForm, ThemeAdmin, HeadTag, useTable} = importComponentPage();
export default {
    name: "ShowLog",
    components: {Confirm, ReadyOnly, ShowForm, HeadTag, ThemeAdmin},
    props: {
        data: {type: Object, default: null},
    },
    setup(props, {attrs}) {
        const {
            title,
            description,
            canonical,
            dataTbody,
            getEditData,
            editData,
            attrsDecode
        } = useTable(attrs, props, 'global.show_log', 'global.show_log_description');

        return {title, description, canonical, dataTbody, getEditData, editData, attrsDecode}
    }

}
</script>

<style scoped>

</style>
