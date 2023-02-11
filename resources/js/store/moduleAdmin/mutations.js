export default {
    SET_UPLOAD_IMAGE: (state, file) => {
        state.uploadImage = file
    },
    SET_LIST_IMAGE: (state, data) => {
        state.listImage = data;
    },
    SET_OLD_IMAGE: (state, data) => {
        state.oldImage = data;
    },
    CLEAR_LIST_IMAGE: (state) => {
        state.listImage = [];
        state.oldImage = [];
    },
}
