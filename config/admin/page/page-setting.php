<?php
$lang = require(resource_path('lang/vi/global.php'));
return [
    'button' => [
        'see' => [
            'lang' => $lang['see'],
            'icon' => 'circle-check',
            'class' => 'text-azure',
            'type' => 'see',
        ],
        'edit' => [
            'lang' => $lang['edit'],
            'icon' => 'pen',
            'class' => '',
            'type' => 'edit',
        ]
    ],
    'thead' => [
        'log' => [
            'id' => '<input class="form-check-input m-0 align-middle" type="checkbox" aria-label="select all">',
            'file_line' => $lang['file'],
            'message_code' => $lang['content'],
            'screen' => $lang['screen'],
            'created_at' => $lang['date_time'],
            'button' => ''
        ],
        'member' => [
            'id' => '<input class="form-check-input m-0 align-middle" type="checkbox" aria-label="select all">',
            'customer_type' => $lang['customer_type'],
            'full_name' => $lang['full_name'],
            'gender' => $lang['gender'],
            'birthday' => $lang['birthday'],
            'address' => $lang['address'],
            'phone' => $lang['phone'],
            'email' => $lang['email'],
            'account' => $lang['account'],
            'room_number' => $lang['room_number'],
            'room_district' => $lang['room_district'],
            'remark' => $lang['remark'],
            'remember_token' => $lang['remember_token'],
            'uuid' => $lang['uuid'],
            'is_block' => $lang['is_block'],
            'is_delete' => $lang['is_delete'],
            'email_verified_at' => $lang['email_verified_at'],
            'created_by' => $lang['created_by'],
            'created_at' => $lang['created_at'],
            'updated_by' => $lang['updated_by'],
            'updated_at' => $lang['updated_at'],
            'button' => ''
        ],
        'room' => [
            'id' => '<input class="form-check-input m-0 align-middle" type="checkbox" aria-label="select all">',
            'room_number' => $lang['room_number'],
            'title' => $lang['title'],
            'description' => $lang['description'],
            'address' => $lang['address'],
            'district_id' => $lang['district_id'],
            'price' => $lang['price'],
            'acreage' => $lang['acreage'],
            'characteristics' => $lang['characteristics'],
            'star' => $lang['star'],
            'hot_id' => $lang['hot_id'],
            'exist_id' => $lang['exist'],
            'status_id' => $lang['status_id'],
            'created_by' => $lang['created_by'],
            'created_at' => $lang['created_at'],
            'updated_by' => $lang['updated_by'],
            'updated_at' => $lang['updated_at'],
            'button' => ''
        ],
    ],
    'filter' => [
        'log' => 'show,sort,time',
        'member' => 'show,sort,time',
        'room' => 'show,sort,time',
    ],
];
