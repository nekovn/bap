<?php

namespace App\Http\Requests\Admin;

use App\Enums\CodeDefine;
use App\Enums\DefaultDefine;
use App\Helpers\SystemHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class RoomRequest extends FormRequest
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
        //=======================title=======================//
        if (isset($data['title'])) $rules['title'] = 'required|string|min:5|max:150';
        //=======================description=======================//
        if (isset($data['description'])) $rules['description'] = 'required|string|min:5|max:300';
        //=======================address=======================//
        if (isset($data['address'])) $rules['address'] = 'required|string|min:5|max:150';
        //=======================price (最低：1.000.000,最大：10.000.000）=======================//
        if (isset($data['price'])) $rules['price'] = 'required|numeric|min:1000000|max:10000000';
        //=======================acreage=======================//
        if (isset($data['acreage'])) $rules['acreage'] = 'required|string|min:5|max:10';
        //=======================characteristics=======================//
        if (isset($data['characteristics'])) $rules['characteristics'] = 'required|string|min:5|max:20';
        //=======================star=======================//
        if (isset($data['star'])) $rules['star'] = 'required|numeric|min:1|max:5';
        //=======================hot_id=======================//
        if (isset($data['hot_id'])) $rules['hot_id'] = 'required|numeric|max:1';
        //=======================exist_id=======================//
        if (isset($data['exist_id'])) $rules['exist_id'] = 'required|numeric|max:1';
        //=======================status_id=======================//
        if (isset($data['status_id'])) $rules['status_id'] = 'required|numeric|max:1';
        //=======================room_district=======================//
        if (isset($data['district_id'])) {
            $rules['district_id'] = [
                'required',
                'numeric',
            ];
        }
        //=======================room_number=======================//
        if (isset($data['room_number'])) {
            $rules['room_number'] = [
                'required',
                'string',
                'min:4',
                'max:6',
                // roomに関して、room.room_numberが同一かつ有効なデータで、valueが同一のデータがあればNGとする
                Rule::unique('room')->where(function ($query) use($data) {
                    return $query->where('room_number', $data['room_number'])
                        ->where('district_id', $data['district_id']);
                })
            ];
        }
        //=======================room_image=======================//
        if (isset($data['room_image'])) $rules['room_image'] = 'nullable|array|image|mimes:jpeg,png,jpg|max:1024';
        //=======================created_by=======================//
        if (isset($data['created_by'])) $rules['created_by'] = 'nullable|string|max:15';
        //=======================updated_by=======================//
        if (isset($data['updated_by'])) $rules['updated_by'] = 'nullable|string|max:15';
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
