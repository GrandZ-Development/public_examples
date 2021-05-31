<?php

namespace App\Modules\Restaurant\Api\v1\Requests;

use App\Modules\Restaurant\Api\v1\Rules\ValidSeat;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateReservationRequest extends FormRequest
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
            'table_id' => ['required', 'exists:tables,id', Rule::unique('table_reservations')->where(function ($q){
                return $q->where('is_open', true);
            })],
            'no_of_seats' => ['required', new ValidSeat($this->table_id)],
        ];
    }
}
