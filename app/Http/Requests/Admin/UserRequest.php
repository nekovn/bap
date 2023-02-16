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

class UserRequest extends FormRequest
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
        //=======================full_name=======================//
        if (isset($data['full_name'])) $rules['full_name'] = 'required|string|min:5|max:30';
        //=======================gender=======================//
        if (isset($data['gender'])) $rules['gender'] = 'required|numeric';
        //=======================address=======================//
        if (isset($data['address'])) $rules['address'] = 'required|string|min:5|max:100';
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
        //=======================email=======================//
        if (isset($data['email'])) {
            $rules['email'] = [
                'required',
                'email',
                Rule::unique('customers')->where('is_delete', CodeDefine::INACTIVE_VALUE)
            ];
        }
        //=======================remark=======================//
        if (isset($data['remark'])) $rules['remark'] = 'nullable|max:255';
        //=======================birthday=======================//
        if (isset($data['birthday'])) $rules['birthday'] = 'nullable|string|regex:/\d{4}\/?\d{2}\/?\d{2}/';
        //=======================code=======================//
        if (isset($data['code'])) $rules['code'] = 'required|string|max:5';
        //=======================permissions=======================//
        if (isset($data['permissions'])) $rules['permissions'] = 'required|numeric|max:3';
        //=======================is_delete=======================//
        if (isset($data['is_delete'])) $rules['is_delete'] = 'required|numeric|max:1';
        //=======================is_block=======================//
        if (isset($data['is_block'])) $rules['is_block'] = 'required|numeric|max:1';
        //=======================uuid=======================//
        if (isset($data['uuid'])) $rules['uuid'] = 'nullable|string|max:50';
        //=======================created_by=======================//
        if (isset($data['created_by'])) $rules['created_by'] = 'nullable|string|max:15';
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
