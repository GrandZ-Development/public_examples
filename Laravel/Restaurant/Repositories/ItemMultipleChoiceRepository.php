<?php


namespace App\Modules\Restaurant\Repositories;


use App\Modules\BaseRepository;
use App\Modules\Restaurant\Models\ItemMultipleChoice;
use Illuminate\Database\Eloquent\Model;

class ItemMultipleChoiceRepository extends BaseRepository
{


    public function __construct(ItemMultipleChoice $model)
    {
        parent::__construct($model);
    }



    public function getItemOptions(){

        return $this->model->orderBy('name','asc')->get();
    }

}
