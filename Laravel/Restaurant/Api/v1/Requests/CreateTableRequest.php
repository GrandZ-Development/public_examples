<?php

namespace App\Modules\Restaurant\Api\v1\Requests;

use App\Enums\TableType;
use Illuminate\Foundation\Http\FormRequest;

class CreateTableRequest extends FormRequest
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
        $types = implode(',', TableType::getValues());
        return [
            'name'        => 'required|unique:tables,name',
            'section_id'        => 'required|exists:sections,id',
            'type'        =>  'required|in:'.$types,
            'no_of_seats' =>  'required|numeric|min:1|max:6',
            'can_merge'    =>  'required|boolean',
            'image_id' => 'required|exists:images,id',
            'seat_image_id' => 'required|exists:images,id',

        ];
    }

    public function messages()
    {

        return [
            'name.unique' => 'Table name already exist'
        ];
    }
}
