<template>
    <div class="col-4" v-for="(item, index) in editData" :key="index" v-if="editData.length">
        <label class="form-imagecheck my-1" @click="show(index)">
            <img :src="item.name" width="100" height="80" class="card-img-top accordion-item" role="img" aria-label="show-image">
        </label>
    </div>
</template>
<script>
export default {
    name: "ImageLightBox",
    props: {
        editData: {default: []},
    },
    setup(props, {emit}) {
        const {editData} = props;
        //画像表示
        const show = (index) => {
            //画像取得
            const image = editData.map(item => item.name);
            //lightbox表示
            emit('show', {index, image})
        }
        return {show}
    }
}
</script>

<style scoped>

</style>
