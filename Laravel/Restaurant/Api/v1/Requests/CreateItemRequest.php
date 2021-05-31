<?php

namespace App\Modules\Restaurant\Api\v1\Requests;


use Illuminate\Foundation\Http\FormRequest;

class CreateItemRequest extends FormRequest
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
            'type'         => 'required|in:side,upsell,item,beverages,toppings',
            'category_id'   => 'required_if:type,item',
            'name'         => 'required',
            'description'  => 'required',
            'sku'          => 'required',
            'availability' => 'required_if:type,item',
            'has_price'        =>  'required',
            'price'        =>  'required_if:has_price,1',
            'take_out_price'        =>  'required_if:has_price,1',
            // 'delivery_price'        =>  'required_if:has_price,1',
            'additional_fees' => 'array',
            'ingredients'     => 'array',
            'upsells'         => 'array',
            'toppings'        => 'array',
            'sides'           => 'array',
            'multiple_choices' => 'array',
            'additional_fees.*.fee_id' => 'required|exists:fees,id|distinct',
            'additional_fees.*.amount' => 'required|numeric|min:1',
            'ingredients.*.ingredient_id' => 'required|exists:ingredients,id|distinct',
            'ingredients.*.quantity' => 'required|numeric|min:0.01',
            'upsells.*.upsell_id'    => 'required|exists:items,id',
//            'upsells.*.is_available'    => 'required|boolean',
            'status'        => 'string',
            'out_of_stock'  => 'numeric',
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
