<template>
    <div class="modal-footer">
        <Close :btn="btn" :element="element"/>
        <Save :btn="btn" :element="element" :router="router" v-if="data"/>
        <Edit :btn="btn" :element="element" :router="router" v-if="data" :oldData="oldData"/>
    </div>
</template>

<script>
import {importComponentModalButton} from "../../../../composables/Admin/useImportFile";
const {Close, Save, Edit} = importComponentModalButton();
export default {
    name: "ModalFooter",
    components: {Edit, Save, Close},
    props: {
        element: {type: String, default: ''},
        btn: {type: String, default: ''},
        router: {type: String, default: ''},
        data: {default: null},
        oldData: {default: null}
    }
}
</script>

<style scoped>

</style>
