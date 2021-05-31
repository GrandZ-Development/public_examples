<?php

namespace App\Modules\Restaurant\Api\v1\Requests;

use App\Enums\TableType;
use Illuminate\Foundation\Http\FormRequest;

class StoreTableRequest extends FormRequest
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
            'id'        => 'nullable|exists:tables',
            'name'        => 'required',
            'section_id'        => 'required|exists:sections,id',
            'type'        =>  'required|in:'.$types,
            'no_of_seats' =>  'nullable|numeric|min:0|max:10',
            'can_merge'    =>  'nullable|boolean',
            'position' => 'required'

        ];
    }

    public function messages()
    {

        return [
            'name.unique' => 'Table name already exist'
        ];
    }
}
