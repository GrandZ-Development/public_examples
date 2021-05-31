<?php


namespace App\Modules\Restaurant\Repositories;



use App\Modules\BaseRepository;
use App\Modules\Restaurant\Models\Floor;
use App\Modules\Restaurant\Models\Image;
use App\Modules\Restaurant\Models\Table;
use Illuminate\Database\Eloquent\Model;

class FloorRepository extends BaseRepository
{
    public function __construct(Floor $model)
    {
        parent::__construct($model);
    }
    public function list()
    {
        return $this->model->with(['sections' => function($q){
            $q->orderBy('created_at');
        }])->get();
    }
    public function getFloorPlan()
    {
        return $this->model->with(['sections' => function($q){
            $q->with(['tables' => function($query){
                $query->with(['seats', 'open_reservation']);
            }]);
            $q->orderBy('created_at');
        }])->get();
    }

}
