<?php

namespace App\Http\Controllers\Admin\Container;

use App\Enums\CodeDefine;
use App\Models\Code;

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
                    'type' => 'phone',
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
                'uuid' => [
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
                'created_by' => [
                    'form' => 'input',
                    'type' => 'hidden',
                    'placeholder' => '',
                    'value' => '',
                    'class' => '',
                    'required' => false,
                    'disabled' => false,
                    'maxlength' => '10',
                    'control' => [],
                    'title' => '',
                    'isCreate' => true,
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
