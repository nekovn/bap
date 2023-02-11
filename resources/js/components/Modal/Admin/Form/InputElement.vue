<template>
    <!-- Phone Input -->
    <hyphen-input-element v-if="item.type === 'tel'" :item="item" :name="name" :value="editData"/>
    <!-- Checkbox -->
    <checkbox-input-element v-else-if="item.type === 'checkbox'" :item="item" :name="name" :editData="editData"/>
    <!-- 普通 Input -->
    <div v-else>
        <input :type="item.type" :name="name" :class="item.class" :maxlength="item.maxlength" :disabled="item.disabled"
               :value="editData" :placeholder="item.placeholder" :required="item.required" autocomplete="off"
               :aria-label="name">
    </div>
    <!-- エラーメッセージ -->
    <span class="form-hint bg-red-lt" :data-message="`${name}`"></span>
</template>

<script>
import {onMounted} from "vue";
import {preventInputWrongFormat} from "../../../../helpers/FormHelper";
import {importComponentInput} from "../../../../composables/Admin/useImportFile";
const {HyphenInputElement, CheckboxInputElement} = importComponentInput();
export default {
    name: "InputElement",
    components: {CheckboxInputElement, HyphenInputElement},
    props: {
        item: {type: Object, default: null},
        name: {type: String, default: null},
        element: {type: String, default: ''},
        editData: {default: ''},
    },
    setup(props) {
        const {element} = props;
        onMounted(() => {
            //画面要素
            const idElm = document.getElementById(element);
            //タイプ：number||tellは文字を入力すると、削除する
            //full_nameはナンバーを入力すると、削除する
            preventInputWrongFormat(idElm);
        })
    }
}
</script>

<style scoped>

</style>
