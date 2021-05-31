<?php

namespace App\Modules\Restaurant\Models;

use App\Modules\BaseModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemMultipleChoice extends Model
{


    use BaseModelTrait;
    use SoftDeletes;

    public $incrementing = false;

    protected $fillable = ['name','options','image'];

}
