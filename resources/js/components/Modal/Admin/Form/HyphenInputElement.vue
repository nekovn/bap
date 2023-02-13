<template>
    <div class="d-flex">
        <template v-for="(val,key) in list" :key="key">
            <!-- tel -->
            <input type="tel" :maxlength="val.length" :class="item.class" :name="val.name" :aria-label="name" :value="value?.split('-')[key] || ''"/>
            <!-- ハイフン -->
            <img alt="hyphen" aria-label="hyphen" src="/assets/img/hyphen.svg" width="10" v-if="key < (list.length-1)">
        </template>
    </div>
</template>

<script>

export default {
    name: "HyphenInputElement",
    props: {
        item: {type: Object, default: null},
        name: {type: String, default: null},
        value: {default: []}
    },
    setup(props) {
        const {name} = props;
        const list = [
            {
                'name': `${name}_01`,
                'length': '4'
            },
            {
                'name': `${name}_02`,
                'length': '3'
            },
            {
                'name': `${name}_03`,
                'length': '3'
            },

        ];
        return {list};
    }
}
</script>

<style scoped>

</style>
