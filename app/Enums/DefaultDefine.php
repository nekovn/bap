<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

class DefaultDefine extends Enum implements DefineInterface
{
    const PER_PAGE = 10;
    const PER_PAGE_LIST = '10,20,30,40,50';
    const STATUS_BTN = 0;
    const SORT_DESC = 'DESC';
    const SORT_ASC = 'ASC';
    const IMAGE_PATH = 'images/banner';
    const IMAGE_ROOM_PATH = 'images/room';
    const IMAGE_CUSTOMER_PATH = 'images/client';
    const IMAGE_DISK_PATH = 'storage_image';
    const ACCEPT_IMG = 'image/jpeg, image/png, image/jpg';
    const CACHE_ROOM = 'list-room';
    const EXPIRE = 10; //期限切れ
    const CREATE_SECOND = 180; //期限切れ(180秒 -> 3分)
    const STATUS_SUCCESS = 200; //成功
    const STATUS_SUCCESS_202 = 202; //成功: CREATE-[POST/PUT/PATH]
    const STATUS_SUCCESS_201 = 201;
    const STATUS_NO_CONTENT = 204; //No content [Xóa]
    const STATUS_NOT_MODIFIED = 304; //Not Modified
    const STATUS_BAD_REQUEST = 400;
    const STATUS_UNAUTHORIZED = 401;
    const STATUS_FORBIDDEN = 403;
    const STATUS_NOT_FOUND = 404;
    const STATUS_406 = 406;
    const STATUS_410 = 410;
    const STATUS_TO_MANY_REQUEST = 429; //Too Many Requests
    const STATUS_422 = 422; //Validation error occurred
    const STATUS_SERVER_ERROR = 500;


    public static function getKeyValue(): array
    {
        return [];
    }

    public static function getMethods(): array
    {
        return [];
    }
}
