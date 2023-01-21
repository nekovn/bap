<template>
    <div class="layout-fluid theme-light">
        <HeadTag :title="title" :description="description" :canonical="canonical"/>
        <ThemeAdmin :title="title">
            <div class="page-body">
                <div class="container-xl">
                    <div class="row row-deck row-cards">
                        <div>test</div>
                    </div>
                </div>
            </div>
        </ThemeAdmin>
    </div>
</template>

<script>
import HeadTag from "@components/Head/HeadTag";
import ThemeAdmin from "@themes/Admin/ThemeAdmin";
export default {
    name: "Dashboard",
    components: {HeadTag, ThemeAdmin},
    data() {
        return {
            'title': this.$t("global.dashboard"),
            'description': this.$t("global.dashboard_description"),
            'canonical': `${window.location.origin}${this.$page.url}`,
        }
    }
}
</script>

<style scoped>

</style>
