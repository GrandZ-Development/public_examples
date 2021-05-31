<?php

namespace App\Modules\Restaurant\Api\v1\Requests;


use Illuminate\Foundation\Http\FormRequest;

class CreateSideRequest extends FormRequest
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
            'name'         => 'required|unique:sides',
            'description'  => 'required',
            'sku'          => 'required',
            'availability' => 'required|array',
            'price'        =>  'required|numeric|min:0.01',
            'additional_fees' => 'array',
            'ingredients'     => 'array',
            'additional_fees.*.fee_id' => 'required|exists:fees,id|distinct',
            'additional_fees.*.amount' => 'required|numeric|min:1',
            'ingredients.*.ingredient_id' => 'required|exists:ingredients,id|distinct',
            'ingredients.*.quantity' => 'required|numeric|min:1'
        ];
    }



    public function messages()
    {
       return [
           'name.unique' => 'Item name already exist',
           'additional_fees.*.fee_id.exists' => 'The selected fee in invalid',
           'ingredients.*.ingredient_id' => 'The selected fee in invalid'
       ];
    }
}
