import {createApp, defineAsyncComponent, h} from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
//多数言語
import {i18n_setting} from "./lang/i18n";
//fontawesome アイコンをインポートする
const FontAwesomeIcon = defineAsyncComponent(() => import("./plugins/icon"));
//ストアをインストールする
import store from "./store";
createInertiaApp({
    resolve: name => defineAsyncComponent(() => import(`./pages/${name}`)),
    setup({ el, App, props, plugin }) {
        //多数言語
        const i18n = i18n_setting(props);
        const app = createApp({ render: () => h(App, props) })
            .mixin({methods: {route}})
            .component('font-awesome-icon', FontAwesomeIcon)
            .use(i18n)
            .use(store)
            .use(plugin);
        app.config.globalProperties.appName = process.env.MIX_APP_NAME
        app.mount(el)
    },
})
