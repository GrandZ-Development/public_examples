<?php


namespace App\Modules\Restaurant\Repositories;


use App\Modules\BaseRepository;
use App\Modules\Restaurant\Models\Side;
use Illuminate\Database\Eloquent\Model;

class SideRepository extends BaseRepository
{


    public function __construct(Side $model )
    {
        parent::__construct($model);
    }

    public function listSides(){
        return $this->model->orderBy('name', 'asc')->get();
    }



}
