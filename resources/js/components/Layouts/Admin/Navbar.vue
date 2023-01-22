<template>
    <aside class="navbar navbar-vertical navbar-expand-lg menu-admin">
        <div class="container-fluid">
            <NavbarToggler/>
            <NavbarIcon/>
            <div class="collapse navbar-collapse" id="sidebar-menu">
                <ul class="navbar-nav pt-lg-3">
                    <li class="nav-item" v-for="(item,key) in routeList" :key="key"
                        :class="{'active': $page.url === item.url}">
                        <Link class="nav-link" :href="item.url">
                          <span class="btn d-md-none d-lg-inline-block shadow-lg px-2" :class="{'shadow-lg-active': $page.url === item.url}">
                              <font-awesome-icon :icon="item.icon"/>
                          </span>
                          <span class="ms-3 nav-link-title">
                            {{ item.name }}
                          </span>
                        </Link>
                    </li>
                </ul>
            </div>
        </div>
    </aside>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";
import {importComponentLayout} from "../../../composables/Admin/useImportFile";
const {NavbarIcon, NavbarToggler} = importComponentLayout();
export default {
    name: "Navbar",
    components: {NavbarToggler, NavbarIcon, Link},
    data() {
        return {
            routeList: [
                {'name': this.$t('global.home'), 'url': '/', 'icon': 'house-user'}, //Home
                {'name': this.$t('global.dashboard'), 'url': '/admin/dashboard', 'icon': 'chart-line'}, //Dashboard
                {'name': this.$t('global.member'), 'url': '/admin/member', 'icon': 'id-card'}, //Member
                {'name': this.$t('global.list_room'), 'url': '/admin/room', 'icon': 'hotel'}, //List room
                {'name': this.$t('global.show_log'), 'url': '/admin/show-log', 'icon': 'bug'}, //Show log
                {'name': this.$t('global.logout'), 'url': route('admin.logout'), 'icon': 'right-from-bracket'},//Logout
            ]
        }
    }
}
</script>

<style scoped>

</style>
