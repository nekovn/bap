<?php

namespace App\Enums;
use BenSampo\Enum\Enum;

final class CodeDefine extends Enum implements DefineInterface
{

    const MAIL_SETTING = 100;
    const ACTIVE_VALUE = 1;
    const INACTIVE_VALUE = 0;
    const CODE_DISTRICT = 101;
    const CODE_ROOM_EXIST = 102;
    const CODE_STAR = 103;
    const CODE_HOT = 104;
    const CODE_STATUS = 105;
    CONST SPACE_ROOM = 101;
    CONST SPACE_SHARE = 102;
    CONST UTILITY_ROOM = 103;
    CONST CUSTOMER_TYPE = 106;
    CONST CODE_GENDER = 107;
    CONST CODE_DELETE = 108;
    CONST CODE_BLOCK = 109;
    CONST GUEST_USER = 1; //Đọc dữ liệu
    CONST BASIC_USER = 2; //Nhập dữ liệu
    CONST ADVANCED_USER = 5; //Quản lý dữ liệu


    public static function getKeyValue(): array
    {
        return self::getConstants();
    }
    public static function getMethods(): array
    {
        return [];
    }
}
