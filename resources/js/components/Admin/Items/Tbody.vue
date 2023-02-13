<template>
    <tbody>
    <!-- TR -->
    <tr v-for="(val,key) in getTbody" :key="key" v-if="getTbody?.length">
        <!-- TD -->
        <template v-for="(columnVal,columnName) in listThead" :key="columnName">
            <!--  チェックボックス  -->
            <td v-if="columnName === 'id'">
                <input class='form-check-input m-0 align-middle' type='checkbox' aria-label="select item"
                       role="checkbox" :data-id="val['id']">
            </td>
            <!--  普通カラム  -->
            <td v-html="showTbody(val, columnName)" v-else-if="columnName !== 'id' && columnName !== 'image' && columnName !== 'button'"></td>
            <!--  ボタン  -->
            <td v-else-if="columnName === 'button'">
                <template v-for="(btn,type) in val['button']" :key="type">
                    <span :title="btn['lang']" class="btn fs-4 px-2 mx-1"
                          :aria-label="type" role="button"
                          @click="handleClickBtn($event, val['id'], type)">
                        <font-awesome-icon :icon="btn['icon']" class="px-2" :class="btn['class']"/>
                        <span>{{ btn['lang'] }}</span></span>
                </template>
            </td>
        </template>
    </tr>
    <!-- データがない時 -->
    <tr v-else class="h3">{{ $t('global.data_empty') }}</tr>
    </tbody>
</template>

<script>
import {reactive, computed} from "vue";
import {useStore} from "vuex";
import {showListContent} from "../../../helpers/Flash";

export default {
    name: "Tbody",
    props: {
        tHead: {type: Object, default: null},
        tBody: {type: Array, default: []},
    },
    emits: ['editData'],
    setup(props, {emit}) {
        const store = useStore();
        const {tHead, tBody} = props;
        const getTbody = computed(() => store.getters.GET_TBODY_DATA || tBody);
        //Thead
        const listThead = reactive(tHead);
        /**
         * 普通カラムを表示する
         * @param value
         * @param column
         * @return {string}
         */
        const showTbody = (value, column) => {
            let xhtml = '';
            let className = '';
            if (value[column]) {
                switch (column) {
                    case 'is_block':
                    case 'is_delete':
                    case 'exist_id':
                        className = (value[column]['key']).toString() === '0' ? 'bg-success' : 'bg-danger';
                        xhtml += showStatusText(className, value[column], value['id']);
                        break;
                    case 'status_id':
                    case 'hot_id':
                        className = (value[column]['key']).toString() === '0' ? 'bg-secondary' : 'bg-warning';
                        xhtml += showStatusText(className, value[column], value['id']);
                        break;
                    default:
                        if (typeof  value[column] === 'string' || typeof  value[column] === 'number') {
                            xhtml += showTextContent( value[column]);
                        } else if (typeof  value[column] === 'object' && value[column] && value[column]['value']) {
                            xhtml += showTextContent(value[column]['value']);
                        } else if (typeof value[column] === 'object' && value[column]?.length) {
                            xhtml += showListContent(value[column]);
                        }
                        break;
                }
            }

            return xhtml;


        }

        /**
         * ステータス表示
         * @param className
         * @param attribute
         * @param id
         * @return string
         */
        const showStatusText = (className, attribute, id) => {
            return `<span class='badge const ${className} me-1' title='${attribute['value']}' data-id='${id}' data-status='${attribute['key']}'></span>
                    ${attribute['value']}`;
        }

        /**
         * コンテンツ表示
         * @param attribute
         * @return string
         */
        const showTextContent = (attribute) => {
            return `<span class='text-muted hidden-text' title='${attribute}'>${attribute}</span>`;
        }

        /**
         * ボタンをクリックする時
         * @param e イベント
         * @param id ID
         * @param type ボタンのタイプ
         */
        const handleClickBtn = (e, id, type) => {
            e.preventDefault();
            e.stopImmediatePropagation();
            //idによって、データを取得する
            const value = getTbody.value.filter(val => val.id.toString() === id.toString());
            //ボタンのタイプによって、ポップ画面を表示する
            showModalByType(type, value.shift());
        }

        /**
         * ボタンのタイプによって、ポップ画面を表示する
         * @param type
         * @param data
         */
        const showModalByType = (type, data) => {
            switch (type) {
                case 'see':
                    handleEventSee(data);
                    break;
                case 'edit':
                    handleEventEdit(data);
                    break;
                default:
                    break;
            }
        }

        /**
         * 詳しいデータを見る
         */
        const handleEventSee = (data) => {
            //Modalを開く
            store.dispatch('setShowReadyModal', true);
            //親に編集データを宣言する
            emit('editData', data);
        }

        /**
         * 詳しいデータを編集する
         // * @param data
         */
        const handleEventEdit = (data) => {
            //Modalを開く
            store.dispatch('setShowEditModal', true);
            //親に編集データを宣言する
            emit('editData', data);
        }

        return {listThead, showTbody, handleClickBtn, getTbody};
    },

}
</script>

<style scoped>

</style>
