<?php

namespace App\Modules\Restaurant\Api\v1\Requests;

use App\Enums\TableType;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTableRequest extends FormRequest
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
            'id'           => 'required|exists:tables,id',
            'name'         => 'required',
            'type'         => 'required|in:'.$types,
//            'no_of_seats'  => 'required|numeric|min:1',
            'can_merge'    => 'required|boolean'
        ];
    }
}
