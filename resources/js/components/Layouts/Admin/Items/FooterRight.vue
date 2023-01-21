<template>
    <div>
        {{ $t('global.access_time') }}：{{ getAccessDateTime }}
    </div>
</template>
<script>
import {computed} from "vue";
import {getCurrentDateTime} from "../../../../helpers/Flash";

export default {
    name: "FooterRight",
    setup() {
        //アクセス時間を取得する
        const getAccessDateTime = computed(() => {
            //日付関数
            const today = getCurrentDateTime('/');
            //アクセス日付時間
            return `${today.date} ${today.time}`;
        });
        return {getAccessDateTime}
    }
}
</script>

<style scoped>

</style>
