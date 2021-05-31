<?php

namespace App\Modules\Restaurant\Models;

use App\Modules\BaseModelTrait;
use Illuminate\Database\Eloquent\Model;

class BusinessHour extends Model
{
    use BaseModelTrait;

    public $incrementing = false;

    protected $fillable = ['day', 'start_time', 'end_time', 'closed'];


}
