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
