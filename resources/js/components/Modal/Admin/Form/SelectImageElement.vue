<template>
    <div class="modal-body" v-if="GET_LIST_IMAGE.length">
        <div class="row">
            <div class="col-3" v-for="(item, index) in GET_LIST_IMAGE" :key="index">
                <label class="form-imagecheck mb-2">
                    <span class="close-image"  @click="handleCloseImage" :data-value="item.id" role="img" aria-label="close-image">
                        <font-awesome-icon icon="xmark"/>
                    </span>
                    <img :src="item.name" width="150" height="120" class="card-img-top accordion-item" role="img" aria-label="show-image">
                </label>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "../../../../store/map-state";
import {onMounted} from "vue";
import {useStore} from "vuex";


export default {
    name: "SelectImageElement",
    props: {
        editData: {default: []},
    },
    setup(props) {
        const {editData} = props;
        const store = useStore();
        const {GET_LIST_IMAGE} = mapGetters();
        onMounted(async () => {
            //初期化の時、ステートからImageデータを削除する
            await store.commit('CLEAR_LIST_IMAGE');
            //ステートにImageデータを導入する
            await store.dispatch('setListImage', {image: editData});
            //ステートに元Imageデータを導入する
            await store.dispatch('setListImageOld', {image: editData});
        })

        const handleCloseImage = (e) => {
            const {currentTarget} = e;
            const value = currentTarget.dataset?.value;
            //削除
            if (value){
                const data = store.getters.GET_LIST_IMAGE.filter(item => item.id !== value)
                store.commit('SET_LIST_IMAGE', data)
            }
        }
        return {GET_LIST_IMAGE, handleCloseImage}
    }
}
</script>

<style scoped>

</style>
