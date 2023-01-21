<template>
    <!-- Select -->
    <select :class="item.class" :name="name" :disabled="item.disabled"
            :data-disabled="item.disabled"
            :data-bind="item.control?.bind" :data-method="item.control?.method" @change="handleSelect">
        <option value="" :data-disabled="item.disabled" selected>{{ item.placeholder }}</option>
        <option v-for="(item, index) in item.value?.code_value" :key="index" :value="item.key" v-if="item.value"
                :aria-label="name" role="option">
            {{ item.value }}
        </option>
    </select>
    <!-- エラーメッセージ -->
    <span class="form-hint bg-red-lt" :data-message="`${name}`"></span>
</template>

<script>
import {useStore} from "vuex";
import {selectItemBind} from "../../../../helpers/Flash";
export default {
    name: "SelectElement",
    props: {
        item: {type: Object, default: null},
        name: {type: String, default: null},
        element: {type: String, default: ''},
    },
    setup(props) {
        const {element} = props;
        const store = useStore();
        const handleSelect = async (e) => {
            const {currentTarget} = e
            e.preventDefault();
            e.stopImmediatePropagation();
            //画面要素
            const idElm = document.getElementById(element);
            //制御名 (controllers/admin/container/defineContainer)
            const controlName = currentTarget.dataset.bind;
            //制御メソッド (controllers/admin/container/defineContainer)
            const controlMethod = currentTarget.dataset.method;
            if (controlName && controlMethod && idElm) {
                //制御要素
                const controlElm = idElm.querySelector(`select[name="${controlName}"]`);
                const target = currentTarget.value;
                //Selectが非活性にする
                controlElm && target ? controlElm.disabled = false : controlElm.disabled = true;
                //Keyとvalueを取得する為に、APIを呼び出し
                await selectItemBind(store, controlMethod, controlElm, target, currentTarget);
            }
        }
        return {handleSelect}
    }
}
</script>

<style scoped>

</style>
