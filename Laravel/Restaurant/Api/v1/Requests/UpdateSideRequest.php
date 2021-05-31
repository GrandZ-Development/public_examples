<?php

namespace App\Modules\Restaurant\Api\v1\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSideRequest extends FormRequest
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
            'id'           => 'required|exists:sides',
            'name'         => 'required',
            'description'  => 'required',
            'sku'          => 'required',
            'availability' => 'required|array',
            'price'        =>  'required|numeric|min:0.01',
            'additional_fees' => 'array',
            'ingredients'     => 'array',
            'image'           => 'image',
            'additional_fees.*.fee_id' => 'required|exists:fees,id',
            'additional_fees.*.amount' => 'required|numeric|min:1',
            'ingredients.*.ingredient_id' => 'required|exists:ingredients,id',
            'ingredients.*.quantity' => 'required|numeric|min:1'
        ];
    }



    public function messages()
    {
        return [
            'additional_fees.*.fee_id.exists' => 'The selected fee in invalid',
            'ingredients.*.ingredient_id' => 'The selected ingredient in invalid'
        ];
    }
}
