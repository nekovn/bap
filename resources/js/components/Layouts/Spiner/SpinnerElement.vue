<template>
    <div :class="{'loading': true, 'show': GET_LOADING}">
        <div class="dots" role="status">
            <h2>{{ $t('global.loading') }}<span class="animated-dots"></span></h2>
        </div>

    </div>
</template>

<script>
import {mapGetters} from "../../../store/map-state";

export default {
    name: "SpinnerElement",
    setup() {
        const {GET_LOADING} = mapGetters();
        return {GET_LOADING}
    }
}
</script>

<style scoped>

</style>
