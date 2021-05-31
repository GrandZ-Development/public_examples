<?php

namespace App\Modules\Restaurant\Models;

use App\Modules\BaseModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use BaseModelTrait;

    public $incrementing = false;
    protected $perPage = 10;

    protected $guarded = ['id'];


    public function getImagePathAttribute()
    {
        return asset($this->image);
    }
}
