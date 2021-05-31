<?php

namespace App\Modules\Restaurant\Models;

use App\Modules\BaseModelTrait;
use Illuminate\Database\Eloquent\Model;

class HolidayDay extends Model
{
    use BaseModelTrait;

    public $keyType = 'string';

    protected $hidden = ['created_at', 'updated_at'];

//    protected $casts = ['id' => 'string'];

    public $incrementing = false;

    public $table = "holiday_days";

    protected $fillable = ['date', 'closed','name'];

    public function hours(){
        return $this->hasOne('App\Modules\Restaurant\Models\HolidayHour', 'day_id');
    }
}
