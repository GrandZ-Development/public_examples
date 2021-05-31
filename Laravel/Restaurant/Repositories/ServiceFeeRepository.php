<?php


namespace App\Modules\Restaurant\Repositories;


use App\Modules\BaseRepository;
use App\Modules\Restaurant\Models\ServiceFee;
use Illuminate\Database\Eloquent\Model;

class ServiceFeeRepository extends BaseRepository
{


    public function __construct(ServiceFee $model )
    {
        parent::__construct($model);
    }


    public function feeAlreadyExist($name, $id){

        return $this->model->where('name', $name)->where('id', '<>', $id)->count() > 0;
    }


    public function getFees(){
        return $this->model->orderBy('name', 'asc')->get();
    }
}
