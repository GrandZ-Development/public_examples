<?php

namespace App\Modules\Restaurant\Models;

use App\Modules\BaseModelTrait;
use App\Modules\Inventory\Models\Ingredient;
use App\Modules\Inventory\Models\Topping;
use App\Modules\Order\Api\v1\Enums\OrderType;
use App\Modules\Settings\Models\Category;
use App\Modules\Settings\Models\Fee;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    use BaseModelTrait;

    public $incrementing = false;


    protected $fillable = ['name', 'type','description','category_id','sku','availability','price', 'take_out_price', 'delivery_price', 'additional_fees','image','upsells' ,'ingredients', 'multiple_choices','toppings','sides', 'status', 'out_of_stock', 'has_price'];


    public function scopeOfType($query, $type){
        return $query->where('type', $type);
    }

    public function scopeOfCategory($query, $categoryId){
        return $query->where('category_id', $categoryId);

    }


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


    public function getUpsellsAttribute($value){
        $upsells = json_decode($value, true);

       return collect($upsells)->map(function ($upsell){
          $item = Item::find($upsell['upsell_id']);

          if($item){
              return [
                  'upsell_id' => $item->id,
                  'name'       => $item->name,
                  'image'      => url('storage/'.$item->image),
                  'price'      => $item->price
//                  'is_available' => $upsell['is_available']
              ];
          }

          return  null;

       })->filter(function ($upsell){
           return !is_null($upsell);
       });
    }


    public function getSidesAttribute($value){
        $sides = json_decode($value, true);

        return collect($sides)->map(function ($side){
            $item = Item::find($side['side_id']);

            if($item){
                return [
                    'side_id' => $item->id,
                    'name'       => $item->name,
                    'image'      => url('storage/'.$item->image),
                    'price'       => $item->price
                ];
            }

            return  null;

        })->filter(function ($side){
            return !is_null($side);
        });
    }


    public function getToppingsAttribute($value){
        $toppings = json_decode($value, true);

        return collect($toppings)->map(function ($topping){
            $item = Item::find($topping['topping_id']);

            if($item){
                return [
                    'topping_id' => $item->id,
                    'name'       => $item->name,
                ];
            }

            return  null;

        })->filter(function ($topping){
            return !is_null($topping);
        });
    }



    public function getMultipleChoicesAttribute($value){
        $choices = json_decode($value, true);

        return collect($choices)->map(function ($choice){
            $item = ItemMultipleChoice::find($choice['choice_id']);

            if($item){
                return [
                    'choice_id' => $item->id,
                    'name'       => $item->name,
                ];
            }

            return  null;

        })->filter(function ($choice){
            return !is_null($choice);
        });
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }


    public function toggleOutOfStock(){

        $item = $this;
        try {
            if ($item->out_of_stock == 1) {
            $item->update([
                'out_of_stock'  => 0
                ]);
            }else{
                $item->update([
                    'out_of_stock'  => 1
                ]);
            }
            return true;

        } catch (Exception $e) {
            return false;
        }
    }
    public function priceByType($type)
    {
        $price = $this->price;
        if ($type == OrderType::TAKEOUT)
            $price = $this->take_out_price;
        elseif ($type == OrderType::DELIVERY)
            $price = $this->delivery_price;
        return $price;
    }
    public function getImageUrlAttribute()
    {
        if($this->image && file_exists(storage_path('app/public/'.$this->image)))
            url('storage/'.$this->image);
        return asset('images/food-picture.png');
    }






}
