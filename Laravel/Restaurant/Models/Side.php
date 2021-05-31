<?php

namespace App\Modules\Restaurant\Models;

use App\Modules\BaseModelTrait;
use App\Modules\Inventory\Models\Ingredient;
use App\Modules\Settings\Models\Fee;
use Illuminate\Database\Eloquent\Model;

class Side extends Model
{

    use BaseModelTrait;

    public $incrementing = false;

    protected $fillable = ['name', 'description','sku','availability','price','additional_fees','image', 'ingredients'];


    public function getAdditionalFeesAttribute($value){
        $fees = json_decode($value, true);
        return  collect($fees)->map(function ($item){
            $fee = Fee::find($item['fee_id']);
            if($fee){
                return [
                    'fee_id' => $fee->id,
                    'name'   => $fee->name,
                    'amount' => $item['amount']
                ];
            }
            return  null;
        })->filter(function ($fee) {
            return !is_null($fee);
        })->toArray();


    }


    public function getIngredientsAttribute($value){
        $ingredients =  json_decode($value, true);
        return  collect($ingredients)->map(function ($item){

            $ingredient = Ingredient::find($item['ingredient_id']);
            if($ingredient){
                return [
                    'ingredient_id' =>$ingredient->id,
                    'name' => $ingredient->name,
                    'quantity' => $item['quantity']
                ];
            }
            return null;
        })->filter(function ($ingredient){
            return !is_null($ingredient);
        });
    }

}
