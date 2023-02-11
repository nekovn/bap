<template>
    <input type="file" :name="name" :class="item.class" :accept="item.type" :disabled="item.disabled"
           :value="editData" :placeholder="item.placeholder" :required="item.required" :aria-label="name"
           @change="handleUploadFile" multiple>
    <span class="form-hint bg-red-lt" :data-message="name"></span>
</template>

<script>
import {useStore} from "vuex";
import {checkImageFile} from "../../../../helpers/FormHelper";
import {useI18n} from "vue-i18n";


export default {
    name: "UploadFileElement",
    props: {
        item: {type: Object, default: null},
        name: {type: String, default: null},
        element: {type: String, default: ''},
        editData: {default: ''},
    },
    setup(props) {
        const store = useStore();
        const {name} = props;
        const {t} = useI18n();
        /**
         * 画像をアップロードする
         * @param e
         */
        const handleUploadFile = (e) => {
            e.preventDefault();
            e.stopImmediatePropagation();
            if (window.File && window.FileReader && window.FileList && window.Blob) {
                const {currentTarget} = e;
                const {files} = currentTarget;
                if (files && files.length) {
                    let file = {};
                    for (let i = 0; i < files.length; i++) {
                        if (!files[i].type.match("image")) continue;
                        const objectFile = files[i];
                        const nameFile = objectFile.name;
                        //画像の形式をチェックする
                        const isValid = checkImageFile(objectFile);
                        if (!isValid) {
                            store.commit('SET_TOAST', {
                                title: t('global.error'), content: t('global.image_valid'), class: 'show bg-danger',
                            })
                            return;
                        }
                        //エラーメッセージ削除
                        store.commit('SET_TOAST', {});
                        //ロード
                        const read = new FileReader();
                        read.readAsDataURL(objectFile);
                        read.addEventListener('load', () => {
                            //File
                            file[`${nameFile}`] = objectFile;
                            //image
                            let image = [
                                {
                                    name: read.result,
                                    id: nameFile,
                                    isNewFile: true
                                }
                            ];
                            if (file) {
                                //ステートにファイル設定
                                store.dispatch('setUploadImage', {file});
                                store.dispatch('setListImage', {image});
                                //アップロードした後、空白設定
                                currentTarget.value = '';
                            }
                        })
                    }
                }


            }
        }
        return {handleUploadFile}
    }
}
</script>

<style scoped>

</style>
