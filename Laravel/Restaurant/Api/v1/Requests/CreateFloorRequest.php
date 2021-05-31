<?php

namespace App\Modules\Restaurant\Api\v1\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFloorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'image_id' => 'required|exists:images,id'
        ];
    }
}
