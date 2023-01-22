<?php

namespace App\Http\Requests\Admin;

use App\Enums\CodeDefine;
use App\Enums\DefaultDefine;
use App\Helpers\SystemHelper;
use App\Rules\PasswordPolicy;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class MemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    public function validationData(): array
    {
        return SystemHelper::getValidationData($this);
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $data = $this->validationData();
        $rules = [];
        //=======================id=======================//
        if (isset($data['id'])) $rules['id'] = 'nullable|string|max:50';
        //=======================customer_type=======================//
        if (isset($data['customer_type'])) $rules['customer_type'] = 'required|numeric';
        //=======================gender=======================//
        if (isset($data['gender'])) $rules['gender'] = 'required|numeric';
        //=======================full_name=======================//
        if (isset($data['full_name'])) $rules['full_name'] = 'required|string|min:5|max:30';
        //=======================phone=======================//
        if (isset($data['phone'])) {
            $rules['phone'] = [
                'required',
                'string',
                'max:12',
                'regex:/^0\d{3}-?\d{3}-?\d{3}/',
                Rule::unique('customers')->where('is_delete', CodeDefine::INACTIVE_VALUE)
            ];
        }
        //=======================address=======================//
        if (isset($data['address'])) $rules['address'] = 'required|string|min:5|max:100';
        //=======================remark=======================//
        if (isset($data['remark'])) $rules['remark'] = 'nullable|max:255';
        //=======================birthday=======================//
        if (isset($data['birthday'])) $rules['birthday'] = 'nullable|string|regex:/\d{4}\/?\d{2}\/?\d{2}/';
        //=======================email=======================//
        if (isset($data['email'])) {
            $rules['email'] = [
                'required',
                'email',
                Rule::unique('customers')->where('is_delete', CodeDefine::INACTIVE_VALUE)
            ];
        }
        //=======================user_name=======================//
        if (isset($data['user_name'])) {
            $rules['user_name'] = [
                'required',
                Rule::unique('customers')->where('is_delete', CodeDefine::INACTIVE_VALUE),
                'min:3',
                'max:10'
            ];
        }
        //=======================account=======================//
        if (isset($data['account'])) $rules['account'] = 'required|string|min:2|max:10';
        //=======================is_block=======================//
        if (isset($data['is_block'])) $rules['is_block'] = 'required|numeric|max:1';
        //=======================is_delete=======================//
        if (isset($data['is_delete'])) $rules['is_delete'] = 'required|numeric|max:1';
        //=======================uuid=======================//
        if (isset($data['uuid'])) $rules['uuid'] = 'nullable|string|max:50';
        //=======================created_by=======================//
        if (isset($data['created_by'])) $rules['created_by'] = 'nullable|string|max:15';
        //=======================room_district=======================//
        if (isset($data['room_district'])) {
            $rules['room_district'] = [
                'nullable',
                'numeric',
            ];
        }
        //=======================room_number=======================//
        if (isset($data['room_number'])) {
            $rules['room_number'] = [
                'nullable',
                'string',
                'required_with:room_district',
                // roomに関して、room_numberカラムはroom.exist_idが既存するかどうかチェックする、値：１ -> NG
                Rule::exists('room')->where(function ($query) {
                    return $query->where('exist_id', CodeDefine::INACTIVE_VALUE)
                        ->where('status_id', CodeDefine::ACTIVE_VALUE);
                })
            ];
        }
        //=======================password=======================//
        if (isset($data['password'])) {
            $rules['password'] = [
                'required',
                new PasswordPolicy()
            ];
        }
        //=======================updated_at=======================//
        $rules['updated_at'] = 'nullable|date|max:19';

        return $rules;
    }

    /**
     * NGの時、クライアントに返すレスポンスデータをする
     */
    protected function failedValidation(Validator $validator)
    {
        $key = array_keys($validator->errors()->toArray());
        $value = $validator->errors()->all();
        $errors = array_combine($key, $value);
        $response = response()->json([
            'status' => DefaultDefine::STATUS_BAD_REQUEST,
            'message' => __('messages.errors_valid'),
            'errors' => $errors
        ]);
        throw new HttpResponseException($response);
    }

}
