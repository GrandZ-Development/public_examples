<?php

namespace App\Modules\Restaurant\Api\v1\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class DeleteHolidayDayRequest extends FormRequest
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
            'id' => 'required|exists:holiday_days,id'
        ];
    }


    public function messages()
    {

        return [
            'id,*' => 'There is no date with this id address'
        ];
    }
}
