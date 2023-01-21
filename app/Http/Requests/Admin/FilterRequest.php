<?php

namespace App\Http\Requests\Admin;

use App\Enums\DefaultDefine;
use App\Helpers\SystemHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class FilterRequest extends FormRequest
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
    public function validationData():array
    {
        return SystemHelper::getValidationData($this);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $data = $this->validationData();
        $rules = [];
        //=======================物理削除ID=======================//
        if (isset($data['deleteId'])) $rules['deleteId'] = 'nullable|array|max:30';
        //=======================1ページあたり=======================//
        if (isset($data['per_page'])) $rules['per_page'] = 'nullable|string|max:2';
        //=======================ページネーションフラグ=======================//
        if (isset($data['isLimit'])) $rules['isLimit'] = 'nullable|boolean';
        //=======================ページ位置=======================//
        if (isset($data['offset'])) $rules['offset'] = 'nullable|numeric|max:500';
        //=======================1ページあたり=======================//
        if (isset($data['sort'])) $rules['sort'] = 'nullable|string|max:4';
        //=======================開始時間=======================//
        if (isset($data['dateStart'])) $rules['dateStart'] = 'nullable|date';
        //=======================終了時間=======================//
        if (isset($data['dateEnd'])) $rules['dateEnd'] = 'nullable|date';
        //=======================自由検索=======================//
        if (isset($data['keyword'])) $rules['keyword'] = 'nullable|string|regex:/[a-zA-Z0-9]$/';

        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        $value = $validator->errors()->all();
        $response = response()->json([
            'status' => DefaultDefine::STATUS_422,
            'message' => array_shift($value),
            'errors' => []
        ]);
        throw new HttpResponseException($response);
    }
}
