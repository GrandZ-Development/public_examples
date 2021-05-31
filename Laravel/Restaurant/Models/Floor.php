<?php

namespace App\Modules\Restaurant\Models;

use App\Modules\BaseModelTrait;
use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    use BaseModelTrait;

    public $incrementing = false;
    protected $perPage = 10;
    protected $keyType = 'string';


    protected $guarded = ['id'];


    public function sections()
    {
        return $this->hasMany(Section::class);
    }


}
