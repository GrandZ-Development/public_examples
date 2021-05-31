<?php


namespace App\Modules\Restaurant\Repositories;


use App\Modules\BaseRepository;
use App\Modules\Restaurant\Models\Table;
use App\Modules\Restaurant\Models\TableReservation;
use Illuminate\Database\Eloquent\Model;

class TableReservationRepository extends BaseRepository
{


    public function __construct(TableReservation $model)
    {
        parent::__construct($model);
    }


}
