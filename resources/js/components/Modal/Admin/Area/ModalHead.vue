<template>
    <div class="modal-header">
        <h5 class="modal-title">{{ title }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal_close" aria-label="Close"></button>
    </div>
</template>

<script>
export default {
    name: "ModalHead",
    props: {
        title: {type: String, default: null}
    }
}
</script>

<style scoped>

</style>
