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
        <Edit :router="attrsDecode?.router" :editData="editData"/>
        <Create :router="attrsDecode?.router"/>
    </teleport>
</template>
<script>
import {importComponentPage} from "../../composables/Admin/useImportFile";
const {Edit, Create, Confirm, ReadyOnly, ShowForm, ThemeAdmin, HeadTag, useTable} = importComponentPage();
export default {
    name: "User",
    components: {Edit, Create, Confirm, ReadyOnly, ShowForm, HeadTag, ThemeAdmin},
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
        } = useTable(attrs, props, 'global.user', 'global.user_description');

        return {title, description, canonical, dataTbody, getEditData, editData, attrsDecode}
    }

}
</script>

<style scoped>

</style>
