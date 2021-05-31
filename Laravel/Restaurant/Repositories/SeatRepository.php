<?php


namespace App\Modules\Restaurant\Repositories;



use App\Modules\BaseRepository;
use App\Modules\Restaurant\Models\Seat;

class SeatRepository extends BaseRepository
{
    public function __construct(Seat $model)
    {
        parent::__construct($model);
    }
}
