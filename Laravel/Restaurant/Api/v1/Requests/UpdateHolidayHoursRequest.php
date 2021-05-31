<?php

namespace App\Modules\Restaurant\Api\v1\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class UpdateHolidayHoursRequest extends FormRequest
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
            'id' => 'required|exists:holiday_days,id',
            'start_time' => [
                'required',
            ],
            'end_time' => [
                'required',

            ], 'date' => [
                'required',
                'date_format:Y-m-d'
            ],
            'name' => [
                'required',
            ],
        ];
    }


    public function messages()
    {

        return [
            'id,*' => 'There is no date with this id address',
            'start_time.*' => 'Start Time Is required',
            'end_time.*' => 'End Time Is required',
            'date.*' => 'Holiday Date Is required',
            'name.*' => 'Holiday Name Is required',
        ];
    }
}
