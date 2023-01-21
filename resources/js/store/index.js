import {createStore} from 'vuex'
import moduleAdmin from "./moduleAdmin";
import {getEncodeParam, getRandomString, retrieveDecodeCrypto} from "../middleware/crypto";
import axiosInstance from "../api/axios";
import {handleCatchError, getCurrentDateTime} from "../helpers/Flash";
import i18n from '../lang/vue-i18n-locales';

const {vi} = i18n;

const store = createStore({
    state: {
        responseResult: {},
        theadData: [],
        tbodyData: null,
        confirm: {
            isShow: false,
            content: '',
            data: []
        },
        alert: {
            errors: null,
            success: ''
        },
        attrs: [],
        isLoading: false,
        toast: {
            title: '',
            content: '',
            class: '', //show,bg-danger,bg-success
        },
        datePicker: '',
        isShowCreateModal: false,
        isShowEditModal: false,
        isShowReadyModal: false,
    },
    actions: {
        /* APIを呼び出す */
        async callApi({commit, getters}, {data = {}, url = '', action = 'post'}) {
            //ロードアイコンを開始する
            commit('SET_LOADING', true);
            try {
                //公開キー、スタンプタイム
                const {uuid} = getters.GET_ATTRS;
                //スタンプタイム+1分
                const {stampTime} = getCurrentDateTime('/', 1);
                //nonceキー
                const nonce = getRandomString()?.words.join('-');
                //エンコードのデータを設定する
                data = {...data, stampTime, nonce};
                //秘密キー
                const secretKey = process.env.MIX_PUSHER_APP_SECRET;
                //暗号化
                const target = JSON.stringify(data);
                //パスフレーズ
                const passphrase = `${secretKey}-${uuid}`;
                //通信パラメータを設定する
                const setPostParam = getEncodeParam(target, passphrase);
                //ヘッダ設定
                let headers = {
                    'authorization': `Bearer ${setPostParam?.bearer}`,
                    'content-encoding': 'br',
                };
                //結果設定
                let result = {};
                //通信パラメータ
                const postParam = {'target': setPostParam?.param};
                //API呼び出し
                switch (action) {
                    case 'post':
                        result = await axiosInstance.post(url, postParam, {headers});
                        break;
                    case 'get':
                        result = await axiosInstance.get(url, {params: postParam, headers});
                        break;
                    case 'put':
                        result = await axiosInstance.put(url, postParam, {headers});
                        break;
                }
                //レスポンスデータ設定
                await commit('SET_RESPONSE_DATA', result?.data);
                //ロードアイコンを停止する
                commit('SET_LOADING', false);
                //レスポンス結果取得
                return getters.GET_RESPONSE_DATA;
            } catch (error) {
                //サーバからエラー発生する時
                return handleCatchError(commit, vi);
            }
        },
        setTheadData: ({commit}, data) => {
            commit('SET_THEAD_DATA', data);
        },
        setTbodyData: ({commit}, data) => {
            commit('SET_TBODY_DATA', data);
        },
        setConfirm: ({commit}, data) => {
            commit('SET_CONFIRM', data);
        },
        setAlert: ({commit}, data = {errors: null, success: ''}) => {
            commit('SET_ALERT', data)
        },
        setAttrs: ({commit}, data) => {
            commit('SET_ATTRS', data)
        },
        setLoading: ({commit}, data) => {
            commit('SET_LOADING', data)
        },
        setToast: ({commit}, data = {}) => {
            commit('SET_TOAST', data);
        },
        setDatePicker: ({commit}, data = '') => {
            commit('SET_DATE_PICKER', data);
        },
        setShowCreateModal: ({commit}, data = false) => {
            commit('SET_SHOW_CREATE_MODAL', data)
        },
        setShowEditModal: ({commit}, data = false) => {
            commit('SET_SHOW_EDIT_MODAL', data)
        },
        setShowReadyModal: ({commit}, data = false) => {
            commit('SET_SHOW_READY_MODAL', data)
        },
    },
    mutations: {
        /* レスポンス結果を設定する */
        SET_RESPONSE_DATA: (state, result) => {
            //レスポンス結果
            const {data, message, status, errors} = result;
            //レスポンスデータを取得する
            let responseData = (data && Object.keys(data).length) ? retrieveDecodeCrypto(data) : [];
            //トーストを設定する
            store.commit('SET_TOAST', {});
            //正常の場合は
            if (status === 200) {
                //トーストを設定する
                if (message) {
                    store.commit('SET_TOAST', {
                        title: vi.global.success, content: message, class: 'show bg-blue',
                    });
                }
                //レスポンス結果を設定する
                state.responseResult = {result: true, data: responseData, status};
            } else if (status === 400) {
                //トーストを設定する
                if (message) {
                    store.commit('SET_TOAST', {
                        title: vi.global.error, content: message, class: 'show bg-danger',
                    });
                }
                //レスポンス結果を設定する
                state.responseResult = {result: false, data: errors, status: 400};

            } else {
                if (message) {
                    //トーストを設定する
                    store.commit('SET_TOAST', {
                        title: vi.global.error, content: message, class: 'show bg-danger',
                    });
                }
                //レスポンス結果を設定する
                state.responseResult = {result: false, data: responseData, status};
            }
        },
        SET_THEAD_DATA: (state, data) => {
            state.theadData = data;
        },
        SET_TBODY_DATA: (state, data) => {
            state.tbodyData = data;
        },
        SET_CONFIRM: (state, data) => {
            state.confirm = data;
        },
        SET_ALERT: (state, data) => {
            state.alert = data;
        },
        SET_ATTRS: (state, data) => {
            state.attrs = data;
        },
        SET_LOADING: (state, data) => {
            state.isLoading = data;
        },
        SET_TOAST: (state, data = {}) => {
            state.toast = data;
        },
        SET_DATE_PICKER: (state, data = '') => {
            state.datePicker = data;
        },
        SET_SHOW_CREATE_MODAL: (state, data = false) => {
            state.isShowCreateModal = data;
        },
        SET_SHOW_EDIT_MODAL: (state, data = false) => {
            state.isShowEditModal = data;
        },
        SET_SHOW_READY_MODAL: (state, data = false) => {
            state.isShowReadyModal = data;
        },
    },
    getters: {
        /* レスポンス結果を取得する */
        GET_RESPONSE_DATA: (state) => {
            return state.responseResult;
        },
        GET_THEAD_DATA: (state) => {
            return state.theadData;
        },
        GET_TBODY_DATA: (state) => {
            return state.tbodyData;
        },
        GET_CONFIRM: (state) => {
            return state.confirm;
        },
        GET_ALERT: (state) => {
            return state.alert;
        },
        GET_ATTRS: (state) => {
            return state.attrs;
        },
        GET_LOADING: (state) => {
            return state.isLoading;
        },
        GET_TOAST: (state) => {
            return state.toast;
        },
        GET_DATE_PICKER: (state) => {
            return state.datePicker;
        },
        GET_SHOW_CREATE_MODAL: (state) => {
            return state.isShowCreateModal;
        },
        GET_SHOW_EDIT_MODAL: (state) => {
            return state.isShowEditModal;
        },
        GET_SHOW_READY_MODAL: (state) => {
            return state.isShowReadyModal;
        },
    },
    modules: {
        moduleAdmin
    }
})

export default store;
