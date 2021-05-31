<?php


namespace App\Modules\Restaurant\Repositories;


use App\Modules\BaseRepository;
use App\Modules\Restaurant\Models\BusinessHour;
use Illuminate\Database\Eloquent\Model;

class BusinessHourRepository extends BaseRepository
{


    public function __construct(BusinessHour $businessHour )
    {
        parent::__construct($businessHour);
    }



    public function addTime( array $data){

      return  $this->model->updateOrCreate($data);
      
    }

    public function dayAlreadyExist($day, $id){
        return $this->model->where('day',$day)->where('id','<>', $id)->count() > 0;
    }

    public function getBusinessHours(){
        return $this->model->orderBy('day_index', 'asc')->get();
    }



}
