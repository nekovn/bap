/**
 * サーバからエラー発生する時
 * @param commit
 * @param lang
 * @return Object
 */
const handleCatchError = (commit, lang) => {
    //ロードアイコンを停止する
    commit('SET_LOADING', false);
    //トーストを設定する
    commit('SET_TOAST', {
        title: lang.global.error, content: lang.global.server_error, class: 'show bg-danger',
    });
    //レスポンス結果を返却する
    return {result: false, data: [], status: 500};
};

/**
 * Select制御を処理する
 * @param store
 * @param controlMethod
 * @param controlElm
 * @param target
 * @param currentTarget
 * @param editValue
 */
const selectItemBind = async (store, controlMethod, controlElm, target, currentTarget, editValue = '') => {
    await store.dispatch(controlMethod, {target}).then(res => {
        if (res.result) {
            const data = res.data;
            //option要素を作成する
            let optionElm = '<option value=""></option>';
            for (let i = 0; i < data.length; i++) {
                let {key, value} = data[i];
                let optionValue = key || value;
                let selected = optionValue === editValue ? 'selected' : ''
                optionElm += `<option value="${optionValue}" ${selected}>${value}</option>`;
            }
            //Selectにoption要素を設定する
            controlElm.disabled = false;
            controlElm.innerHTML = '';
            controlElm.innerHTML = optionElm;
        } else {
            //エラーがある時
            controlElm.disabled = true;
            controlElm.value = '';
            currentTarget.value = '';
        }
    });
}

/**
 * データの２つを比較する
 * @param newData
 * @param oldData
 */
const compareData = (newData, oldData) => {
    let arrayOldData = {};
    const keysNewData = Object.keys(newData);
    const lengthNewData = keysNewData.length;
    const notSameData = {}
    if (lengthNewData) {
        for (let i = 0; i < lengthNewData; i++) {
            const key = keysNewData[i];
            const oldValue = oldData[key];
            if (typeof oldValue === 'object') {
                if(!oldValue.length) {
                    arrayOldData[key] = oldValue?.key;
                }
            } else {
                arrayOldData[key] = oldValue;
            }
            //input、radio、selectの時
            if (arrayOldData[key] !== undefined && arrayOldData[key].toString() !== newData[key].toString() && !oldValue.length) {
                notSameData[key] = newData[key];
            }
            //checkboxの時
            if (typeof oldValue === 'object' && oldValue.length) {
                //選択データ比較
                let compareCheckbox = diffArrayCheckbox(newData[key], oldValue);
                //違うデータがあれば、
                if (compareCheckbox.length) {
                    //すべて選択データを取得する
                    notSameData[key] = newData[key];
                }
            }
        }
    }
    return notSameData;
}

/**
 * checkboxデータの２つを比較する
 * @param newItem
 * @param oldItem
 */
const diffArrayCheckbox = (newItem, oldItem) => {
    let notSameVal = []
    let length = newItem.length;
    //check:onの時
    if (length) {
        for (let i = 0; i < length; i++) {
            const newValue = newItem[i];
            let match = oldItem.find(item => item.key.toString() === newValue.toString());
            //違うデータがあれば、配列に入れる
            if (!match) {
                notSameVal.push(newValue)
            }
        }
    } else {
        //check:offの時
        notSameVal = ' ';
    }
    return notSameVal;
}

/**
 * フィルター属性を取得する
 * @param id ID要素
 * @param isGetDate
 * @param isGetShowPage
 * @param isLimit ページネーションフラグ
 * @param isSearch 検索キーワードフラグ
 */
const getAttrFilter = (id, isGetShowPage = false, isGetDate = false, isLimit = true, isSearch = false) => {
    //ID要素
    const idElm = document.getElementById(id);
    //1ページあたり
    let per_page = '';
    if (isGetShowPage) {
        const showPageElm = idElm.querySelector('#show-page');
        per_page = showPageElm?.value;
    }
    //並び順
    const sortElm = idElm.querySelector('#sort');
    const sort = sortElm?.value;
    //日付
    let dateStart = '';
    let dateEnd = '';
    if (isGetDate) {
        //開始時間
        const dateStartElm = idElm.querySelector('input[name="date_start"]');
        dateStart = dateStartElm?.value;
        //終了時間
        const dateEndElm = idElm.querySelector('input[name="date_end"]');
        dateEnd = dateEndElm?.value;
    }
    //ページネーション
    const paginationElm = idElm.querySelector('#pagination');
    let offset = 1;
    if (paginationElm) {
        //現在ページ
        const currentPageElm = paginationElm.querySelector('.pagination-text');
        offset = currentPageElm.dataset.current;
    }
    //検索キーワード
    const searchElm = idElm.querySelector('input[name="keyword"]');
    let keyword = '';
    if (searchElm) {
        if (isSearch) {
            keyword = searchElm.value;
        } else {
            searchElm.value = '';
        }

    }
    return {per_page, sort, dateStart, dateEnd, offset, isLimit, keyword};
}

/**
 * 現在時間取得
 * @param symbol 記号
 * @param plusTime プラス時間
 */
const getCurrentDateTime = (symbol = '', plusTime = 0) => {
    //日付関数
    const today = new Date();
    //現在日付
    const date = today.getFullYear() + symbol + (today.getMonth() + 1) + symbol + today.getDate();
    //現在時間
    const minutes = today.getMinutes() + plusTime;
    const seconds = today.getSeconds();
    const time = today.getHours() + ":" + (minutes < 10 ? `0${minutes}` : minutes) + ":" + (seconds < 10 ? `0${seconds}` : seconds);
    //スタンプタイムへ変換する
    const stampTime = Math.floor(new Date(`${date} ${time}`).getTime() / 1000);
    return {
        date,
        time,
        stampTime
    }
}

/**
 * コンテンツリスト表示
 * @param list
 * @param isHidden
 * @return string
 */
const showListContent = (list, isHidden = true) => {
    const hiddenClass = isHidden ? 'hidden-text' : '';
    let xhtml = '<ul>';
    for (let i = 0; i < list.length; i++) {
        xhtml += `<li class="text-muted ${hiddenClass}">${list[i].value}</li>`;
    }
    xhtml += '</ul>'
    return xhtml;
}


export {
    handleCatchError,
    selectItemBind,
    compareData,
    getAttrFilter,
    getCurrentDateTime,
    showListContent
}
