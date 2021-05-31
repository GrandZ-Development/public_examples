<?php


namespace App\Modules\Restaurant\Repositories;


use App\Modules\BaseRepository;
use App\Modules\Restaurant\Models\Promotion;
use Illuminate\Database\Eloquent\Model;

class PromotionRepository extends BaseRepository
{

    public function __construct(Promotion $model)
    {
        parent::__construct($model);
    }


    public function getPromotions(){

        return $this->model->orderBy('name','asc')->get();
    }



}
