<?php


namespace App\Modules\Restaurant\Repositories;


use App\Modules\BaseRepository;
use App\Modules\Restaurant\Models\SalesTax;
use Illuminate\Database\Eloquent\Model;

class SalesTaxRepository extends BaseRepository
{


    public function __construct(SalesTax $model)
    {
        parent::__construct($model);
    }


    public function getSalesTax(){
        return $this->model->orderBy('name', 'asc')->get();
    }


    public function nameAlreadyExist($name, $id){
        return $this->model->where('name', $name)->where('id', '<>', $id)->count() > 0;
    }
}
