import {computed} from "vue";

const CryptoJS = require("crypto-js");

/**
 * 復号
 * @param cipher
 * @param passphrase
 * @param salt
 * @param iv
 */
const decodeCrypto = (cipher, passphrase, salt, iv) => {
    const key = CryptoJS.PBKDF2(passphrase, CryptoJS.enc.Hex.parse(salt), { hasher: CryptoJS.algo.SHA512, iterations: 100 , keySize: 8});
    return CryptoJS.AES.decrypt(cipher, key, { iv: CryptoJS.enc.Hex.parse(iv)}).toString(CryptoJS.enc.Utf8);
}

/**
 * 暗号化
 * @param plain
 * @param passphrase
 */
const encodeCrypto = (plain, passphrase) => {
    const salt = getRandomString(128);
    const iv = getRandomString();
    const key = CryptoJS.PBKDF2(passphrase, salt, { hasher: CryptoJS.algo.SHA512, iterations: 100, keySize: 8 });
    const cipher = CryptoJS.AES.encrypt(plain, key, {iv: iv});
    return {
        rty : passphrase,
        qer : CryptoJS.enc.Base64.stringify(cipher.ciphertext),
        adf : CryptoJS.enc.Hex.stringify(salt),
        zxc : CryptoJS.enc.Hex.stringify(iv),
    }
}

/**
 * 偶然文字列
 * @param number
 */
const getRandomString = (number = 16) => {
    return CryptoJS.lib.WordArray.random(number);
}

/**
 * 暗号化パラメータ取得
 * @param plain
 * @param passphrase
 */
const getEncodeParam = (plain, passphrase) => {
    //エンコードのデータを設定する
    const encodeData =  encodeCrypto(plain, passphrase);
    //エンコードのデータからiv（zxc）を取得する。
    let {zxc, ...params} = encodeData;
    return {
        param: JSON.stringify(params),
        bearer: zxc
    }
}

/**
 * 復号データ取得
 * @param data
 */
const retrieveDecodeCrypto = (data) => {
    if (data) {
        const abc = computed(() => data.abc);
        const def = computed(() => data.def);
        const ghi = computed(() => data.ghi);
        return JSON.parse(decodeCrypto(abc.value, process.env.MIX_PUSHER_APP_SECRET, def.value, ghi.value));
    } else {
        return [];
    }
}

export {
    decodeCrypto,
    encodeCrypto,
    getEncodeParam,
    getRandomString,
    retrieveDecodeCrypto
};

