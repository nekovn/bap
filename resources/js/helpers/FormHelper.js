import {selectItemBind} from "./Flash";
import store from "../store";

/**
 * 入力されたデータを取得する
 * @param elm 入力画面要素
 */
const getSelectedValue = (elm) => {
    let selectedVal = {};
    //Input要素
    const inputELm = elm.querySelectorAll("input[type='text'], input[type='checkbox'], input[type='email'], input[type='hidden'], " + "input[name='birthday'], input[type='tel'], input[type='number'], input[type='radio']:checked, input[type='password'], textarea, select");
    let tmpData = {};
    let string = '';
    let checkboxValue = [];
    let tmpCheckbox = {};
    for (let i = 0; i < inputELm.length; i++) {
        const name = inputELm[i].name;
        const type = inputELm[i].type;
        const val = regExString(inputELm[i].value, type);
        const ariaLabel = inputELm[i].getAttribute('aria-label');
        if (type === 'tel') {
            if (val) {
                if (tmpData[ariaLabel]) {
                    tmpData[ariaLabel] += 1;
                    //ハイフン付ける
                    string += '-';
                    string += val;
                } else {
                    tmpData[ariaLabel] = 1;
                    string += val;
                }
            }
            selectedVal[ariaLabel] = string;
        } else if (type === 'checkbox') {
            //Checked:onの時
            if (inputELm[i].checked) {
                const fileType = inputELm[i]?.dataset?.file;
                let data = inputELm[i].value;
                //ファイル以外の時
                if (fileType !== 'upload-file') {
                    //初期化の時、設定：tmp[label名] = 1; 配列：空白して一つだけ入れる
                    if (!tmpCheckbox[ariaLabel]) {
                        checkboxValue = [];
                        tmpCheckbox[ariaLabel] = 1;
                        checkboxValue.push(data);
                    } else {
                        //次回の時、 配列にそれぞれ入れる
                        checkboxValue.push(data);
                    }
                    selectedVal[name] = checkboxValue;
                }
            } else {
                //Checked:offかつ配列中にキー名：まだ、データないの時
                if (!selectedVal[name]) {
                    selectedVal[name] = [];
                }
            }

        } else {
            selectedVal[name] = val;
        }
    }
    return selectedVal;
}

/**
 * ステートからアップロード画像ファイルを取得
 * @param addedImage 画面表示用追加済画像
 */
const getUploadFileImage = (addedImage) => {
    //画像ファイル取得
    const updatedImg = store.getters.GET_UPLOAD_IMAGE;
    let image = [];
    if (addedImage.length && updatedImg) {
        for (let i = 0; i < addedImage.length; i++) {
            const idImage = addedImage[i].id;
            if (updatedImg[idImage]) {
                image.push(updatedImg[idImage]);
            }
        }
    }
    return image
}

/**
 * データの２つを比較する
 * @param newItem
 * @param oldItem
 */
function diffArrayById(newItem, oldItem) {
    let id = [];
    let name = [];
    for (let i = 0; i < oldItem.length; i++) {
        const idOldItem = oldItem[i].id;
        const nameOldItem = oldItem[i].name;
        let match = newItem.find(item => item.id === idOldItem && item.name === nameOldItem);
        if (!match) {
            id.push(idOldItem);
            name.push(nameOldItem);
        }
    }
    return {id, name};
}



/**
 * 入力されたデータを表示する
 * @param elm 入力画面要素
 * @param data 入力されたデータ
 */
const showSelectedValue = (elm, data) => {
    //Input要素
    // const inputELm = elm.querySelectorAll("input[type='text'], input[type='checkbox'], input[type='email'], input[type='hidden'], " + "input[name='birthday']," + "input[type='tel'], input[type='radio'], input[type='password'], textarea");
    // let tmpData = {};
    // if (data) {
    //     for (let i = 0; i < inputELm.length; i++) {
    //         const name = inputELm[i].name;
    //         const type = inputELm[i].type;
    //         const value = inputELm[i].value;
    //         const ariaLabel = inputELm[i].getAttribute('aria-label');
    //         const role = inputELm[i].getAttribute('role');
    //         if (data[name] !== undefined) {
    //             if (type === 'radio') {
    //                 if (data[name] && data[name]['key'] === value) {
    //                     inputELm[i].checked = true;
    //                 }
    //             } else if (name === 'birthday') {
    //                 store.dispatch('setDatePicker', data[name]);
    //             } else {
    //                 inputELm[i].value = data[name];
    //             }
    //         } else {
    //             if (type === 'tel') {
    //                 let splitString = data[ariaLabel] ? data[ariaLabel].split('-') : [];
    //                 if (splitString) {
    //                     if (tmpData[ariaLabel]) {
    //                         inputELm[i].value = splitString[tmpData[ariaLabel]];
    //                         tmpData[ariaLabel] += 1;
    //                     } else {
    //                         inputELm[i].value = splitString[0];
    //                         tmpData[ariaLabel] = 1;
    //                     }
    //                 }
    //             } else {
    //                 inputELm[i].value = '';
    //             }
    //         }
    //     }
    // }
}

const showSelectedOption = async (elm, data) => {
    //option要素
    const optionElm = elm.querySelectorAll("option");
    if (data) {
        for (let i = 0; i < optionElm.length; i++) {
            const value = optionElm[i].value;
            const role = optionElm[i].getAttribute('role');
            const ariaLabel = optionElm[i].getAttribute('aria-label');
            if (role === 'option') {
                if (data[ariaLabel] && typeof data[ariaLabel] === 'object' && data[ariaLabel]['key'] === value) {
                    //制御名 (controllers/admin/container/defineContainer)
                    const controlName = optionElm[i].parentNode.dataset.bind;
                    //制御メソッド (controllers/admin/container/defineContainer)
                    const controlMethod = optionElm[i].parentNode.dataset.method;
                    if (controlName && controlMethod) {
                        // 制御要素
                        const controlElm = elm.querySelector(`select[name="${controlName}"]`);
                        //編集する時、セクトされた値取得
                        const editValue = data[controlName];
                        //Keyとvalueを取得する為に、APIを呼び出し
                        await selectItemBind(store, controlMethod, controlElm, value, optionElm[i], editValue);
                    }
                    optionElm[i].selected = true;
                } else {
                    if (data[ariaLabel] === value) {
                        optionElm[i].selected = true;
                    }
                }
            }
        }
    }
}

/**
 * 入力されたデータを削除する
 * @param idElm ID画面要素
 */
const clearValueInput = (idElm) => {
    //stateの値を削除する
    store.commit('SET_UPLOAD_IMAGE', {});
    store.commit('CLEAR_LIST_IMAGE');
    // if (idElm) {
    //     //Input要素
    //     const inputELm = idElm.querySelectorAll("input[type='text'], input[type='file'], input[type='checkbox'], input[type='email'], input[name='birthday']," + "input[type='tel'], input[type='radio'], input[type='password'], textarea, select");
    //     //値を設定する
    //     for (let i = 0; i < inputELm.length; i++) {
    //         const isDisabled = inputELm[i].dataset?.disabled;
    //         const type = inputELm[i].type;
    //         const value = inputELm[i].value;
    //         //ラジオ
    //         if (type === 'radio') {
    //             //デフォルト：true
    //             if (!value) {
    //                 inputELm[i].checked = true;
    //             }
    //         } else {
    //             //非活性
    //             if (isDisabled === 'true') {
    //                 inputELm[i].disabled = true;
    //             }
    //             inputELm[i].value = '';
    //             inputELm[i].checked = false;
    //         }
    //         //赤い枠削除
    //         inputELm[i].classList.remove('is-invalid');
    //         //エラーメッセージ削除
    //         const parentELm = inputELm[i].parentElement.closest('[aria-label="parent"]');
    //         const validMsgElm = parentELm?.querySelector('.form-hint');
    //         if (validMsgElm) validMsgElm.innerHTML = '';
    //     }
    // }
}

/**
 * Invalidメッセージを表示する
 * @param idELm ID画面要素
 * @param data メッセージ配列
 */
const renderInvalidMsg = (idELm = null, data = null) => {
    if (idELm && data) {
        const msgElm = idELm.querySelectorAll(`[data-message]`);
        for (let i = 0; i < msgElm?.length; i++) {
            const nameElm = msgElm[i].dataset?.message;
            const inputELm = idELm.querySelector(`[aria-label="${nameElm}"]`);
            if (msgElm[i]) {
                if (data[nameElm]) {
                    msgElm[i].innerHTML = data[nameElm];
                    //赤い枠設定
                    renderBorderInvalid(inputELm, idELm, nameElm);
                } else {
                    //空白枠削除
                    msgElm[i].innerHTML = '';
                    //赤い枠削除
                    renderBorderInvalid(inputELm, idELm, nameElm, true);
                }
            }
        }
    }
}

/**
 * 赤い枠設定
 * @param inputELm Input要素
 * @param idELm ID画面要素
 * @param validName 無効項目
 * @param isRemove 赤い枠削除
 */
const renderBorderInvalid = (inputELm = null, idELm = null, validName = null, isRemove = false) => {

    if (inputELm?.type === 'tel' || inputELm?.type === 'number' || inputELm?.type === 'checkbox' || inputELm?.type === 'radio') {
        const multiElm = idELm.querySelectorAll(`[aria-label="${validName}"]`);
        const lengths = multiElm.length;
        if (lengths) {
            for (let i = 0; i < lengths; i++) {
                if (inputELm?.type === 'radio') {
                    const spanElm = multiElm[i].parentNode.children[1];
                    isRemove ? spanElm?.classList.remove('is-invalid'): spanElm?.classList.add('is-invalid');
                } else {
                    isRemove ? multiElm[i]?.classList.remove('is-invalid'): multiElm[i]?.classList.add('is-invalid');
                }
            }
        }
    } else {
        isRemove ? inputELm?.classList.remove('is-invalid') :inputELm?.classList.add('is-invalid');
    }
}

/**
 * 特殊文字削除
 * @param string
 * @param type
 * @return string
 */
const regExString = (string, type) => {
    const exception = ['password', 'email', 'textarea', 'hidden'];
    let newString = '';
    //exception以外の時、置き換える
    if (exception.includes(type)) {
        newString = string.trim();
    } else {
        newString = string.trim().replace(/(\s|`|{|}|\\|\^|\||!|'|=|\$)+/g, '')
    }
    return regExEmoji(newString);
}

/**
 * 絵文字削除
 * @param string
 * @return string
 */
const regExEmoji = (string) => {
    return string.replace(/(\u00a9|\u00ae|[\u2000-\u3300]|\ud83c[\ud000-\udfff]|\ud83d[\ud000-\udfff]|\ud83e[\ud000-\udfff])+/g, '');
}

/**
 * タイプ：number||tellは文字を入力すると、削除する
 * full_nameはナンバーを入力すると、削除する
 * @param idELm ID画面要素
 */
const preventInputWrongFormat = (idELm) => {
    const inputELm = idELm.querySelectorAll("input[type='number'], input[type='tel'], input[name='full_name']");
    for (let i = 0; i < inputELm.length; i++) {
        inputELm[i].addEventListener('input', (e) => {
            e.stopImmediatePropagation();
            const {currentTarget} = e;
            let value = currentTarget.value;
            let type = currentTarget.type;
            //タイプ：full_nameはナンバーを入力すると、削除する
            if (type === 'text') {
                currentTarget.value = value.replace(/(\d|`|"|:|{|}|,|\?|\\|-|\*|\+|\^|\[|]|\(|\)|\||@|\/|\.|;|<|>|&|#|!|%|'|=|~|\$)/g, '');
            } else {
                //タイプ：number||tellは文字を入力すると、削除する
                currentTarget.value = value.replace(/[０-９]/g, function (s) {
                    return String.fromCharCode(s.charCodeAt(0) - 65248);
                }).replace(/[^0-9]/g, '');
            }
        });
    }
}

/**
 * 返却されたレスポンスを処理する
 * @param idElm
 * @param data
 * @param actionApi createData || editData
 * @param actionModal setShowCreateModal || setShowEditModal
 * @param isClear
 */
const handleResponseData = (idElm, data, actionApi, actionModal, isClear = true) => {
    //返却されたレスポンスを処理する
    store.dispatch(actionApi, data).then(res => {
        const responseData = res?.data;
        const status = res?.status;
        //正常の時
        if (res?.result && status === 200) {
            //入力されたデータを削除する
            if (isClear) clearValueInput(idElm);
            //作成モダール画面を閉じる
            if (actionModal) store.dispatch(actionModal);
            //レスポンスデータから元の属性データを最新属性データに上書き
            dispatchUpdateData(responseData);
        } else if (status === 204) {
            //ユーザーは更新済の時：
            //レスポンスデータから元の属性データを最新属性データに上書き
            dispatchUpdateData(responseData);
            //作成ボタン || 更新ボタン
            const modalSubmit = idElm.querySelector('[data-bs-dismiss="modal_submit"]');
            modalSubmit?.classList.add('d-none');
        } else {
            renderInvalidMsg(idElm, responseData);
        }
    })
}

/**
 * レスポンスデータから元の属性データを最新属性データに上書き
 * @param responseData
 */
const dispatchUpdateData = (responseData) => {
    //ユーザーは更新済の時：
    let {data, ...newAttrs} = responseData;
    //データをクリエートする時、最新のデータを更新する
    store.dispatch('setTbodyData', data || responseData);
    //属性設定
    let attrs = {};
    if (data) {
        attrs = {...store.getters.GET_ATTRS, ...newAttrs};
    } else {
        const totalPage = '';
        attrs = {...store.getters.GET_ATTRS, totalPage};
    }
    store.dispatch('setAttrs', attrs);
}

/**
 * 画像の形式をチェックする
 * @param file
 * @return {boolean}
 */
const checkImageFile = (file) => {
    let extension = file.name.split('.')[file.name.split('.').length - 1];
    extension = extension.toLowerCase();
    const maxFileSize = 200000;
    return (extension === 'png' || extension === 'jpg' || extension === 'jpeg') && parseInt(file.size) <= maxFileSize;
}


export {
    getSelectedValue,
    showSelectedValue,
    clearValueInput,
    renderInvalidMsg,
    preventInputWrongFormat,
    showSelectedOption,
    handleResponseData,
    checkImageFile,
    diffArrayById,
    getUploadFileImage
}
