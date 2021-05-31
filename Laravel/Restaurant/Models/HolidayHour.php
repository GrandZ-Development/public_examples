<?php

namespace App\Modules\Restaurant\Models;

use App\Modules\BaseModelTrait;
use Illuminate\Database\Eloquent\Model;

class HolidayHour extends Model
{
    use BaseModelTrait;

    public $incrementing = false;

    protected $casts = ['id' => 'string'];

    protected $hidden = ['created_at', 'updated_at', 'id', 'day_id'];

    public $table = "holiday_hours";

    protected $fillable = ['day', 'start_time', 'end_time', 'closed'];


}
