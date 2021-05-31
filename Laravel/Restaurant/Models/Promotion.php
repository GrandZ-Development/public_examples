<?php

namespace App\Modules\Restaurant\Models;

use App\Modules\BaseModelTrait;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use BaseModelTrait;

    public $incrementing = false;

    protected $fillable = ['name','time_type', 'value_type','day','repeat','start_time', 'end_time','start_date','end_date','value','items'];



    public function getItemsAttribute($value){
        $items =  json_decode($value, true);


        return collect($items)->map(function ($item){
            $itemModel = Item::find($item['item_id']);
            if($itemModel){
                return [
                  'name' => $itemModel->name,
                  'item_id' => $itemModel->id
                ];
            }

            return null;

        })->filter(function ($item){
            return !is_null($item);
        });
    }

}
