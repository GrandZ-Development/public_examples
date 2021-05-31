<?php

namespace App\Modules\Restaurant\Models;

use App\Modules\BaseModelTrait;
use Illuminate\Database\Eloquent\Model;

class SalesTax extends Model
{
    use BaseModelTrait;

    public $incrementing = false;

    protected $fillable = ['name', 'tax'];
}
