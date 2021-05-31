<?php


namespace App\Modules\Restaurant\Repositories;


use App\Modules\BaseRepository;
use App\Modules\Restaurant\Models\Item;
use Illuminate\Database\Eloquent\Model;

class ItemRepository extends BaseRepository
{

    public function __construct(Item $model )
    {
        parent::__construct($model);
    }


    public function itemExist($name, $type, $id= null){
        if($id){
            return $this->model->where('name', $name)->where('type', $type)->where('id','<>', $id)->count() > 0;
        }else{
            return $this->model->where('name', $name)->where('type', $type)->count() > 0;
        }
    }





    public function listItems($data){
        $items = $this->model;
        if(isset($data['type'])){
          $items = $items->ofType($data['type']);
        }

        if(isset($data['category_id'])){
            $items = $items->ofCategory($data['category_id']);
        }

        return $items->orderBy('name', 'asc')->get();

    }





}
