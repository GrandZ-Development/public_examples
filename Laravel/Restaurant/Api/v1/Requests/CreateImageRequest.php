<?php

namespace App\Modules\Restaurant\Api\v1\Requests;

use App\Enums\Restaurant\ImageType;
use Illuminate\Foundation\Http\FormRequest;

class CreateImageRequest extends FormRequest
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
        $types = implode(',', ImageType::getValues());
        return [
            'type' => 'required|in:'.$types,
            'image' => 'required'
        ];
    }
}
