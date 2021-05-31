<?php

namespace App\Modules\Restaurant\Models;

use App\Modules\BaseModelTrait;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use BaseModelTrait;

    public $incrementing = false;
    protected $perPage = 10;

    protected $guarded = ['id'];


}
