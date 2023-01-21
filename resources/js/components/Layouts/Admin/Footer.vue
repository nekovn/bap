<template>
    <footer class="footer footer-transparent d-print-none border-top p-0">
        <div class="container-xl">
            <div class="navbar pt-3">
                <footer-left/>
                <footer-right/>
            </div>
        </div>
    </footer>
</template>

<script>
import {importComponentLayout} from "../../../composables/Admin/useImportFile";
const {FooterLeft, FooterRight} = importComponentLayout();
export default {
    name: "Footer",
    components: {FooterRight, FooterLeft}
}
</script>

<style scoped>

</style>
