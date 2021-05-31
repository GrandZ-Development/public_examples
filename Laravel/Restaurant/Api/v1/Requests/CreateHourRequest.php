<?php

namespace App\Modules\Restaurant\Api\v1\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class CreateHourRequest extends FormRequest
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
            'day'   => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday|unique:business_hours',
            'closed' => 'boolean',
            'start_time' => [
                'required',
                function($attribute, $value, $fail) {
                    try {
                        $startTime = Carbon::parse($value);
                    }catch (\Exception $exception){
                        return $fail($attribute.' is invalid.');
                    }

                    try {
                        $endTime = Carbon::parse(request()->input('end_time'));
                        if($startTime->isAfter($endTime)){
                            $fail($attribute.' should be before end time');
                        }
                    }catch (\Exception $e){
                        return  false;
                    }

                    return  false;
                }
            ],
            'end_time' => [
                'required',
                function($attribute, $value, $fail) {
                    try {
                        return Carbon::parse($value);
                    } catch (\Exception $exception) {
                        return $fail($attribute . ' is invalid.');
                    }

                }
//
            ]
        ];
    }


    public function messages()
    {

        return [
          'day.unique' => 'Business already exist'
        ];
    }
}
