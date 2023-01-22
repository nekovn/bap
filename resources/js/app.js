import {createApp, defineAsyncComponent, h} from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
//多数言語
import {i18n_setting} from "./lang/i18n";
//fontawesome アイコンをインポートする
const FontAwesomeIcon = defineAsyncComponent(() => import("./plugins/icon"));
//ストアをインストールする
import store from "./store";
//読み込む
import { InertiaProgress } from '@inertiajs/progress'
InertiaProgress.init({
    // The delay after which the progress bar will
    // appear during navigation, in milliseconds.
    delay: 100,

    // The color of the progress bar.
    color: '#29d',

    // Whether to include the default NProgress styles.
    includeCSS: true,

    // Whether the NProgress spinner will be shown.
    showSpinner: false,

})

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
