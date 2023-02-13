<template>
    <thead>
    <tr>
        <th v-for="(item, key) in listThead" :key="key" :class="{'w-1': key === 'id', 'w-5': key === 'button', 'd-none': key === 'image'}" v-html="item"></th>
    </tr>
    </thead>
</template>

<script>
import {onMounted, reactive} from "vue";

export default {
    name: "Thead",
    props: {
        tHead: {type: Object, default: null}
    },
    setup(props) {
        const listThead = reactive(props.tHead);
        onMounted(() => {
            selectAllItem();
        })
        /**
         * すべて、チェックする
         */
        const selectAllItem = () => {
            const selectAll = document.querySelector('[aria-label="select all"]');
            selectAll?.addEventListener('change', (e) => {
                e.preventDefault();
                e.stopImmediatePropagation();
                const selectItem = document.querySelectorAll('[aria-label="select item"]');
                for (let i = 0; i < selectItem.length; i++) {
                    selectAll.checked ? selectItem[i].checked = true : selectItem[i].checked = false;
                }
            })
        }
        return {listThead};
    }
}
</script>

<style scoped>

</style>
