<template>
    <div class="theme-light">
        <HeadTag :title="title" :description="description" :canonical="canonical"/>
        <ThemeAuth>
            <LoginForm :errors="errors"/>
        </ThemeAuth>
    </div>
</template>

<script>
import LoginForm from "@components/Admin/Auth/LoginForm";
import HeadTag from "@components/Head/HeadTag";
import ThemeAuth from "@themes/Admin/Auth/ThemeAuth";

export default {
    name: "login",
    components: {ThemeAuth, HeadTag, LoginForm},
    props: {
      errors: {type: Object, default: null}
    },
    data() {
        return {
            'title': this.$t("global.login"),
            'description': this.$t("global.login_description"),
            'canonical': `${window.location.origin}${this.$page.url}`,
        }
    },
}
</script>

<style scoped>

</style>
