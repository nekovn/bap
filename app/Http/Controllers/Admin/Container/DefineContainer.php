<?php

namespace App\Http\Controllers\Admin\Container;

use App\Enums\CodeDefine;
use App\Models\Code;
use App\Models\Permission;
use App\Models\Utilities;

class DefineContainer implements DefineInterface
{

    /**
     * インスタンス設定
     * @return $this
     */
    public function instance(): DefineContainer
    {
        return $this;
    }

    /**
     * クライアントに返すinputのhtmlの定数情報を取得する
     * @return array
     */
    public function getInputForm(): array
    {
        return [
            'define-user' => [
                'code' => [
                    'form' => 'input',
                    'type' => 'text',
                    'placeholder' => __('placeholder.code'),
                    'value' => '',
                    'class' => 'form-control',
                    'required' => true,
                    'disabled' => false,
                    'maxlength' => '50',
                    'control' => [],
                    'title' => __('global.code'),
                    'isCreate' => true,
                    'isEdit' => true
                ],
                'full_name' => [
                    'form' => 'input',
                    'type' => 'text',
                    'placeholder' => __('placeholder.full_name'),
                    'value' => '',
                    'class' => 'form-control',
                    'required' => true,
                    'disabled' => false,
                    'maxlength' => '50',
                    'control' => [],
                    'title' => __('global.full_name'),
                    'isCreate' => true,
                    'isEdit' => true
                ],
                'gender' => [
                    'form' => 'radio',
                    'type' => 'radio',
                    'placeholder' => '',
                    'value' => self::getValue(CodeDefine::CODE_GENDER),
                    'class' => 'form-selectgroup-input',
                    'required' => true,
                    'disabled' => false,
                    'maxlength' => '',
                    'control' => [],
                    'title' => __('global.gender'),
                    'isCreate' => true,
                    'isEdit' => true
                ],
                'birthday' => [
                    'form' => 'date',
                    'type' => '',
                    'placeholder' => __('placeholder.birthday'),
                    'value' => '',
                    'class' => 'form-control',
                    'required' => false,
                    'disabled' => false,
                    'maxlength' => '',
                    'control' => [],
                    'title' => __('global.birthday'),
                    'isCreate' => true,
                    'isEdit' => true
                ],
                'address' => [
                    'form' => 'input',
                    'type' => 'text',
                    'placeholder' =>  __('placeholder.address'),
                    'value' => '',
                    'class' => 'form-control',
                    'required' => true,
                    'disabled' => false,
                    'maxlength' => '100',
                    'control' => [],
                    'title' => __('global.address'),
                    'isCreate' => true,
                    'isEdit' => true
                ],
                'phone' => [
                    'form' => 'input',
                    'type' => 'tel',
                    'placeholder' =>  __('placeholder.phone'),
                    'value' => '',
                    'class' => 'form-control',
                    'required' => true,
                    'disabled' => false,
                    'maxlength' => '15',
                    'control' => [],
                    'title' => __('global.phone'),
                    'isCreate' => true,
                    'isEdit' => true
                ],
                'email' => [
                    'form' => 'input',
                    'type' => 'text',
                    'placeholder' => __('placeholder.email'),
                    'value' => '',
                    'class' => 'form-control',
                    'required' => true,
                    'disabled' => false,
                    'maxlength' => '50',
                    'control' => [],
                    'title' => __('global.email'),
                    'isCreate' => true,
                    'isEdit' => true
                ],
                'password' => [
                    'form' => 'input',
                    'type' => 'password',
                    'placeholder' => __('placeholder.password'),
                    'value' => '',
                    'class' => 'form-control',
                    'required' => true,
                    'disabled' => false,
                    'maxlength' => '30',
                    'control' => [],
                    'title' => __('global.password'),
                    'isCreate' => true,
                    'isEdit' => true
                ],
                'remark' => [
                    'form' => 'textarea',
                    'type' => '',
                    'placeholder' => __('placeholder.remark'),
                    'value' => '',
                    'class' => 'form-control',
                    'required' => false,
                    'disabled' => false,
                    'maxlength' => '200',
                    'control' => [],
                    'title' => __('global.remark'),
                    'isCreate' => true,
                    'isEdit' => true
                ],
                'permissions' => [
                    'form' => 'select',
                    'type' => '',
                    'placeholder' => __('placeholder.permissions'),
                    'value' => ['code_value' => Permission::GetPermission()],
                    'class' => 'form-select',
                    'required' => true,
                    'disabled' => false,
                    'maxlength' => '',
                    'control' => [],
                    'title' => __('global.permissions'),
                    'isCreate' => true,
                    'isEdit' => true
                ],
                'is_block' => [
                    'form' => 'radio',
                    'type' => 'radio',
                    'placeholder' => '',
                    'value' => self::getValue(CodeDefine::CODE_BLOCK),
                    'class' => 'form-selectgroup-input',
                    'required' => true,
                    'disabled' => false,
                    'maxlength' => '',
                    'control' => [],
                    'title' => __('global.is_block'),
                    'isCreate' => false,
                    'isEdit' => true
                ],
                'is_delete' => [
                    'form' => 'radio',
                    'type' => 'radio',
                    'placeholder' => '',
                    'value' => self::getValue(CodeDefine::CODE_DELETE),
                    'class' => 'form-selectgroup-input',
                    'required' => true,
                    'disabled' => false,
                    'maxlength' => '',
                    'control' => [],
                    'title' => __('global.is_delete'),
                    'isCreate' => false,
                    'isEdit' => true
                ],
                'updated_at' => [
                    'form' => 'input',
                    'type' => 'hidden',
                    'placeholder' => '',
                    'value' => '',
                    'class' => '',
                    'required' => false,
                    'disabled' => false,
                    'maxlength' => '19',
                    'control' => [],
                    'title' => '',
                    'isCreate' => false,
                    'isEdit' => true
                ],
                'uuid' => [
                    'form' => 'input',
                    'type' => 'hidden',
                    'placeholder' => '',
                    'value' => '',
                    'class' => '',
                    'required' => false,
                    'disabled' => false,
                    'maxlength' => '40',
                    'control' => [],
                    'title' => '',
                    'isCreate' => true,
                    'isEdit' => false
                ],
                'id' => [
                    'form' => 'input',
                    'type' => 'hidden',
                    'placeholder' => '',
                    'value' => '',
                    'class' => '',
                    'required' => false,
                    'disabled' => false,
                    'maxlength' => '50',
                    'control' => [],
                    'title' => '',
                    'isCreate' => true,
                    'isEdit' => true
                ]
            ],
            'define-member' => [
                'customer_type' => [
                    'form' => 'radio',
                    'type' => 'radio',
                    'placeholder' => '',
                    'value' => self::getValue(CodeDefine::CUSTOMER_TYPE),
                    'class' => 'form-selectgroup-input',
                    'required' => true,
                    'disabled' => false,
                    'maxlength' => '',
                    'control' => [],
                    'title' => __('global.customer_type'),
                    'isCreate' => true,
                    'isEdit' => true
                ],
                'full_name' => [
                    'form' => 'input',
                    'type' => 'text',
                    'placeholder' => __('placeholder.full_name'),
                    'value' => '',
                    'class' => 'form-control',
                    'required' => true,
                    'disabled' => false,
                    'maxlength' => '50',
                    'control' => [],
                    'title' => __('global.full_name'),
                    'isCreate' => true,
                    'isEdit' => true
                ],
                'gender' => [
                    'form' => 'radio',
                    'type' => 'radio',
                    'placeholder' => '',
                    'value' => self::getValue(CodeDefine::CODE_GENDER),
                    'class' => 'form-selectgroup-input',
                    'required' => true,
                    'disabled' => false,
                    'maxlength' => '',
                    'control' => [],
                    'title' => __('global.gender'),
                    'isCreate' => true,
                    'isEdit' => true
                ],
                'birthday' => [
                    'form' => 'date',
                    'type' => '',
                    'placeholder' => __('placeholder.birthday'),
                    'value' => '',
                    'class' => 'form-control',
                    'required' => false,
                    'disabled' => false,
                    'maxlength' => '',
                    'control' => [],
                    'title' => __('global.birthday'),
                    'isCreate' => true,
                    'isEdit' => true
                ],
                'address' => [
                    'form' => 'input',
                    'type' => 'text',
                    'placeholder' =>  __('placeholder.address'),
                    'value' => '',
                    'class' => 'form-control',
                    'required' => true,
                    'disabled' => false,
                    'maxlength' => '100',
                    'control' => [],
                    'title' => __('global.address'),
                    'isCreate' => true,
                    'isEdit' => true
                ],
                'phone' => [
                    'form' => 'input',
                    'type' => 'tel',
                    'placeholder' =>  __('placeholder.phone'),
                    'value' => '',
                    'class' => 'form-control',
                    'required' => true,
                    'disabled' => false,
                    'maxlength' => '15',
                    'control' => [],
                    'title' => __('global.phone'),
                    'isCreate' => true,
                    'isEdit' => true
                ],
                'email' => [
                    'form' => 'input',
                    'type' => 'email',
                    'placeholder' => __('placeholder.email'),
                    'value' => '',
                    'class' => 'form-control',
                    'required' => true,
                    'disabled' => false,
                    'maxlength' => '40',
                    'control' => [],
                    'title' => __('global.email'),
                    'isCreate' => true,
                    'isEdit' => true
                ],
                'account' => [
                    'form' => 'input',
                    'type' => 'text',
                    'placeholder' => __('placeholder.account'),
                    'value' => '',
                    'class' => 'form-control',
                    'required' => true,
                    'disabled' => false,
                    'maxlength' => '10',
                    'control' => [],
                    'title' => __('global.account'),
                    'isCreate' => true,
                    'isEdit' => true
                ],
                'password' => [
                    'form' => 'input',
                    'type' => 'password',
                    'placeholder' => __('placeholder.password'),
                    'value' => '',
                    'class' => 'form-control',
                    'required' => true,
                    'disabled' => false,
                    'maxlength' => '30',
                    'control' => [],
                    'title' => __('global.password'),
                    'isCreate' => true,
                    'isEdit' => true
                ],
                'room_district' => [
                    'form' => 'select',
                    'type' => '',
                    'placeholder' => __('placeholder.room_district'),
                    'value' => self::getValue(CodeDefine::CODE_DISTRICT),
                    'class' => 'form-select',
                    'required' => false,
                    'disabled' => false,
                    'maxlength' => '',
                    'control' => [
                        'bind' => 'room_number',
                        'method' => 'getRoomNumber'
                    ],
                    'title' => __('global.room_district'),
                    'isCreate' => true,
                    'isEdit' => true
                ],
                'room_number' => [
                    'form' => 'select',
                    'type' => '',
                    'placeholder' => '',
                    'value' => '',
                    'class' => 'form-select',
                    'required' => false,
                    'disabled' => true,
                    'maxlength' => '',
                    'control' => [],
                    'title' => __('global.room_number'),
                    'isCreate' => true,
                    'isEdit' => true
                ],
                'remark' => [
                    'form' => 'textarea',
                    'type' => '',
                    'placeholder' => __('placeholder.remark'),
                    'value' => '',
                    'class' => 'form-control',
                    'required' => false,
                    'disabled' => false,
                    'maxlength' => '200',
                    'control' => [],
                    'title' => __('global.remark'),
                    'isCreate' => true,
                    'isEdit' => true
                ],
                'is_block' => [
                    'form' => 'radio',
                    'type' => 'radio',
                    'placeholder' => '',
                    'value' => self::getValue(CodeDefine::CODE_BLOCK),
                    'class' => 'form-selectgroup-input',
                    'required' => true,
                    'disabled' => false,
                    'maxlength' => '',
                    'control' => [],
                    'title' => __('global.is_block'),
                    'isCreate' => false,
                    'isEdit' => true
                ],
                'is_delete' => [
                    'form' => 'radio',
                    'type' => 'radio',
                    'placeholder' => '',
                    'value' => self::getValue(CodeDefine::CODE_DELETE),
                    'class' => 'form-selectgroup-input',
                    'required' => true,
                    'disabled' => false,
                    'maxlength' => '',
                    'control' => [],
                    'title' => __('global.is_delete'),
                    'isCreate' => false,
                    'isEdit' => true
                ],
                'updated_at' => [
                    'form' => 'input',
                    'type' => 'hidden',
                    'placeholder' => '',
                    'value' => '',
                    'class' => '',
                    'required' => false,
                    'disabled' => false,
                    'maxlength' => '19',
                    'control' => [],
                    'title' => '',
                    'isCreate' => false,
                    'isEdit' => true
                ],
                'uuid' => [
                    'form' => 'input',
                    'type' => 'hidden',
                    'placeholder' => '',
                    'value' => '',
                    'class' => '',
                    'required' => false,
                    'disabled' => false,
                    'maxlength' => '40',
                    'control' => [],
                    'title' => '',
                    'isCreate' => true,
                    'isEdit' => false
                ],
                'id' => [
                    'form' => 'input',
                    'type' => 'hidden',
                    'placeholder' => '',
                    'value' => '',
                    'class' => '',
                    'required' => false,
                    'disabled' => false,
                    'maxlength' => '50',
                    'control' => [],
                    'title' => '',
                    'isCreate' => true,
                    'isEdit' => true
                ]
            ],
            'define-room' => [
                'room_number' => [
                    'form' => 'input',
                    'type' => 'text',
                    'placeholder' => __('placeholder.room_number'),
                    'value' => '',
                    'class' => 'form-control',
                    'required' => true,
                    'disabled' => false,
                    'maxlength' => '6',
                    'control' => [],
                    'title' => __('global.room_number'),
                    'isCreate' => true,
                    'isEdit' => true
                ],
                'district_id' => [
                    'form' => 'select',
                    'type' => '',
                    'placeholder' => __('placeholder.room_district'),
                    'value' => self::getValue(CodeDefine::CODE_DISTRICT),
                    'class' => 'form-select',
                    'required' => true,
                    'disabled' => false,
                    'maxlength' => '',
                    'control' => [],
                    'title' => __('global.room_district'),
                    'isCreate' => true,
                    'isEdit' => true
                ],
                'title' => [
                    'form' => 'input',
                    'type' => 'text',
                    'placeholder' => __('placeholder.title'),
                    'value' => '',
                    'class' => 'form-control',
                    'required' => true,
                    'disabled' => false,
                    'maxlength' => '150',
                    'control' => [],
                    'title' => __('global.title'),
                    'isCreate' => true,
                    'isEdit' => true
                ],
                'description' => [
                    'form' => 'input',
                    'type' => 'text',
                    'placeholder' => __('placeholder.description'),
                    'value' => '',
                    'class' => 'form-control',
                    'required' => true,
                    'disabled' => false,
                    'maxlength' => '300',
                    'control' => [],
                    'title' => __('global.description'),
                    'isCreate' => true,
                    'isEdit' => true
                ],
                'address' => [
                    'form' => 'input',
                    'type' => 'text',
                    'placeholder' => __('placeholder.address'),
                    'value' => '',
                    'class' => 'form-control',
                    'required' => true,
                    'disabled' => false,
                    'maxlength' => '150',
                    'control' => [],
                    'title' => __('global.address'),
                    'isCreate' => true,
                    'isEdit' => true
                ],
                'price' => [
                    'form' => 'input',
                    'type' => 'number',
                    'placeholder' => __('placeholder.price'),
                    'value' => '',
                    'class' => 'form-control',
                    'required' => true,
                    'disabled' => false,
                    'maxlength' => '10',
                    'control' => [],
                    'title' => __('global.price'),
                    'isCreate' => true,
                    'isEdit' => true
                ],
                'acreage' => [
                    'form' => 'input',
                    'type' => 'text',
                    'placeholder' => __('placeholder.acreage'),
                    'value' => '',
                    'class' => 'form-control',
                    'required' => true,
                    'disabled' => false,
                    'maxlength' => '10',
                    'control' => [],
                    'title' => __('global.acreage'),
                    'isCreate' => true,
                    'isEdit' => true
                ],
                'utility_room' => [
                    'form' => 'input',
                    'type' => 'checkbox',
                    'placeholder' => __('placeholder.utility_room'),
                    'value' => ['code_value' => Utilities::GetUtilities(CodeDefine::UTILITY_ROOM)],
                    'class' => 'form-check',
                    'required' => true,
                    'disabled' => false,
                    'maxlength' => '',
                    'control' => [],
                    'title' => __('global.utility_room'),
                    'isCreate' => true,
                    'isEdit' => true
                ],
                'space_room' => [
                    'form' => 'input',
                    'type' => 'checkbox',
                    'placeholder' => __('placeholder.space_room'),
                    'value' => ['code_value' => Utilities::GetUtilities(CodeDefine::SPACE_ROOM)],
                    'class' => 'form-check',
                    'required' => true,
                    'disabled' => false,
                    'maxlength' => '',
                    'control' => [],
                    'title' => __('global.space_room'),
                    'isCreate' => true,
                    'isEdit' => true
                ],
                'space_share' => [
                    'form' => 'input',
                    'type' => 'checkbox',
                    'placeholder' => __('placeholder.space_share'),
                    'value' => ['code_value' => Utilities::GetUtilities(CodeDefine::SPACE_SHARE)],
                    'class' => 'form-check',
                    'required' => true,
                    'disabled' => false,
                    'maxlength' => '',
                    'control' => [],
                    'title' => __('global.space_share'),
                    'isCreate' => true,
                    'isEdit' => true
                ],
                'star' => [
                    'form' => 'input',
                    'type' => 'number',
                    'placeholder' => __('placeholder.star'),
                    'value' => '',
                    'class' => 'form-control',
                    'required' => true,
                    'disabled' => false,
                    'maxlength' => '2',
                    'control' => [],
                    'title' => __('global.star'),
                    'isCreate' => true,
                    'isEdit' => true
                ],
                'hot_id' => [
                    'form' => 'radio',
                    'type' => 'radio',
                    'placeholder' => '',
                    'value' => self::getValue(CodeDefine::CODE_HOT),
                    'class' => 'form-selectgroup-input',
                    'required' => true,
                    'disabled' => false,
                    'maxlength' => '',
                    'control' => [],
                    'title' => __('global.hot_id'),
                    'isCreate' => true,
                    'isEdit' => true
                ],
                'exist_id' => [
                    'form' => 'radio',
                    'type' => 'radio',
                    'placeholder' => '',
                    'value' => self::getValue(CodeDefine::CODE_ROOM_EXIST),
                    'class' => 'form-selectgroup-input',
                    'required' => true,
                    'disabled' => false,
                    'maxlength' => '',
                    'control' => [],
                    'title' => __('global.exist'),
                    'isCreate' => false,
                    'isEdit' => true
                ],
                'status_id' => [
                    'form' => 'radio',
                    'type' => 'radio',
                    'placeholder' => '',
                    'value' => self::getValue(CodeDefine::CODE_DELETE),
                    'class' => 'form-selectgroup-input',
                    'required' => true,
                    'disabled' => false,
                    'maxlength' => '',
                    'control' => [],
                    'title' => __('global.status_id'),
                    'isCreate' => false,
                    'isEdit' => true
                ],
                'file' => [
                    'form' => 'upload',
                    'type' => '.jpg, .jpeg, .png',
                    'placeholder' => __('placeholder.room_image'),
                    'value' => '',
                    'class' => 'form-control',
                    'required' => false,
                    'disabled' => false,
                    'maxlength' => '1024',
                    'control' => [],
                    'title' => __('global.room_image'),
                    'isCreate' => true,
                    'isEdit' => true
                ],
                'updated_at' => [
                    'form' => 'input',
                    'type' => 'hidden',
                    'placeholder' => '',
                    'value' => '',
                    'class' => '',
                    'required' => false,
                    'disabled' => false,
                    'maxlength' => '19',
                    'control' => [],
                    'title' => '',
                    'isCreate' => false,
                    'isEdit' => true
                ],
                'id' => [
                    'form' => 'input',
                    'type' => 'hidden',
                    'placeholder' => '',
                    'value' => '',
                    'class' => '',
                    'required' => false,
                    'disabled' => false,
                    'maxlength' => '50',
                    'control' => [],
                    'title' => '',
                    'isCreate' => true,
                    'isEdit' => true
                ],
            ]
        ];
    }

    /**
     * コード配列を取得する
     * @param string $code
     * @return array
     */
    public function getValue($code): array
    {
        $data = [];
        $model = Code::where(['code' => $code, 'status' => CodeDefine::ACTIVE_VALUE])->with('code_value')->first();
        if ($model) {
            $data = $model->toArray();
        }

        return $data;
    }
}
