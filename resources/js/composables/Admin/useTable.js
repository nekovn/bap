import {useStore} from "vuex";
import {usePage} from "@inertiajs/inertia-vue3";
import {useI18n} from "vue-i18n/dist/vue-i18n.esm-bundler";
import {ref} from "vue";
import {retrieveDecodeCrypto} from "../../middleware/crypto";

export function useTable(attrs, props, $title, $description) {
    const store = useStore();
    const {url} = usePage();
    const {t} = useI18n();
    //ヘッダーのタイトル
    const title = ref(t($title));
    //ヘッダーの説明
    const description = ref(t($description));
    //ヘッダーのcanonical
    const canonical = `${window.location.origin}${url.value}`;
    //編集データ
    const editData = ref(null);
    //復号属性
    const attrsDecode = retrieveDecodeCrypto(attrs.attribute);
    //復号Room
    const room = retrieveDecodeCrypto(attrs.room);
    //復号Form属性
    const formInput = retrieveDecodeCrypto(attrs.formInput);
    //復号テーストのデータ
    const dataTbody = retrieveDecodeCrypto(props.data);
    //レスポンスデータがある時
    if (dataTbody) {
        //data除き
        let {data, ...newAttrs} = dataTbody;
        //属性Obj結合する
        attrs = {...attrsDecode, room, formInput, ...newAttrs}
        //初期化する時、ステートにデータを導入する
        store.dispatch('setTbodyData', data);
    }
    //トースト非表示
    store.dispatch('setToast');
    //storeに属性入れる
    store.dispatch('setAttrs', attrs);
    //storeにThead入れる
    store.dispatch('setTheadData', attrs.tHead);
    //データを編集する時：
    const getEditData = (data) => {
        editData.value = data;
    }
    return {
        title, description, canonical, dataTbody, getEditData, editData, attrsDecode
    }
}


