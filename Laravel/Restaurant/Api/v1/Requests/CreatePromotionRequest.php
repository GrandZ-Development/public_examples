<?php

namespace App\Modules\Restaurant\Api\v1\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePromotionRequest extends FormRequest
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
            'name'       =>     'required|unique:promotions',
            'time_type'  =>     'required|in:day,date',
            'value_type' =>     'required|in:percentage,amount',
            'start_time' =>     'required',
            'end_time'   =>     'required',
            'day'        =>     'required_if:time_type,day|exclude_if:time_type,date',
            'start_date' =>     'required_if:time_type,date|exclude_if:time_type,day',
            'end_date'   =>     'required_if:time_type,date|exclude_if:time_type,day',
            'repeat'     =>     'boolean|required_if:time_type,day|exclude_if:time_type,date',
            'value'      =>     'required|numeric|min:0.01',
            'items'      =>     'required|array',
            'items.*.item_id' => 'required|exists:items,id'
        ];
    }
}
