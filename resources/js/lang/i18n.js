import { createI18n } from "vue-i18n";
import localeMessages from "./vue-i18n-locales";

const i18n_setting = (props) => new createI18n({
    legacy: false, // you must set `false`, to use Composition API
    locale: props.initialPage.props.lang, // user locale by props
    fallbackLocale: "en", // set fallback locale
    messages: localeMessages, // set locale messages
})

export {
    i18n_setting
};
