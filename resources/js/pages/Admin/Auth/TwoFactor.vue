<template>
    <div class="theme-light">
        <HeadTag :title="title" :description="description" :canonical="canonical"/>
        <ThemeAuth>
            <TwoFactorForm :errors="errors" :success="success"/>
        </ThemeAuth>
    </div>
</template>

<script>
import HeadTag from "../../../components/Head/HeadTag";
import ThemeAuth from "../../../themes/Admin/Auth/ThemeAuth";
import TwoFactorForm from "../../../components/Admin/Auth/TwoFactorForm";
export default {
    name: "TwoFactor",
    components: {TwoFactorForm, ThemeAuth, HeadTag},
    props: {
        errors: {type: Object, default: null},
        success: {type: Object, default: null},
    },
    data() {
        return {
            'title': this.$t("global.two_factor"),
            'description': this.$t("global.two_factor_text"),
            'canonical': `${window.location.origin}${this.$page.url}`,
        }
    },
}
</script>

<style scoped>

</style>
