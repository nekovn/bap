import i18n from '../../lang/vue-i18n-locales';
import {handleCatchError} from "../../helpers/Flash";
const {vi} = i18n;
export default {
    /* データを作成するAPIを呼び出す */
    async createData({dispatch}, {data = {}, url = ''}) {
        return await dispatch('callApi', {data, url});
    },

    /* データを編集するAPIを呼び出す */
    async editData({dispatch}, {data = {}, url = ''}) {
        return await dispatch('callApi', {data, url, action: 'put'});
    },

    /* データをフィルターする */
    async filterData({dispatch}, {data = {}, url = ''}) {
        return await dispatch('callApi', {data, url});
    },

    /* データを並び順する */
    async sortData({commit, getters}, sort) {
        //ロードアイコンを開始する
        commit('SET_LOADING', true);
        //レスポンス結果定義
        let responseResult = {};
        try {
            const data = await getters.GET_TBODY_DATA;
            let newData = null;
            //データがある時：
            if (data?.length && sort) {
                //並び順：
                if (sort === 'asc') {
                    newData = data.sort((a, b) => a.created_at > b.created_at ? 1 : a.created_at < b.created_at ? -1 : 0)
                } else {
                    newData = data.sort((a, b) => a.created_at < b.created_at ? 1 : a.created_at > b.created_at ? -1 : 0)
                }
                //メッセージ内容
                let message = sort === 'asc' ? vi.global.sort_asc : vi.global.sort_desc;
                //トーストを設定する
                commit('SET_TOAST', {
                    title: vi.global.success, content: message, class: 'show bg-blue',
                });
            }
            const clearTime = setTimeout(() => {
                //ロードアイコンを停止する
                commit('SET_LOADING', false);
                clearTimeout(clearTime);
            }, 500)
            //レスポンス結果を設定する
            responseResult = {result: true, data: newData}
        } catch (error) {
            //サーバからエラー発生する時
            return handleCatchError(commit, vi);
        }

    },

    /* room番号を取得する */
    async getRoomNumber({commit, getters}, {target = {}}) {
        //ロードアイコンを開始する
        commit('SET_LOADING', true);
        //レスポンス結果定義
        let responseResult = {};
        try {
            const {room} = await getters.GET_ATTRS;
            const values = room && Object.values(room);
            //district_id === targetかどうかフィルターする
            const data = values?.filter((item) => item.target.toString() === target.toString());
            //正常の場合は
            if (data?.length) {
                //トーストを設定する
                commit('SET_TOAST', {
                    title: vi.global.success, content: vi.global.success_region, class: 'show bg-blue',
                });
                //レスポンス結果を設定する
                responseResult = {result: true, data: data}
            } else {
                //トーストを設定する
                commit('SET_TOAST', {
                    title: vi.global.error, content: vi.global.data_empty, class: 'show bg-danger',
                })
                //レスポンス結果を設定する
                responseResult = {result: false, data: []}
            }
            const clearTime = setTimeout(() => {
                //ロードアイコンを停止する
                commit('SET_LOADING', false);
                clearTimeout(clearTime);
            }, 500)
            //レスポンス結果を返却する
            return responseResult;
        } catch (error) {
            //サーバからエラー発生する時
            return handleCatchError(commit, vi);
        }
    },

}
