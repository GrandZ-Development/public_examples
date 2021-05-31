<?php

namespace App\Modules\Restaurant\Models;

use App\Modules\BaseModelTrait;
use App\Modules\Order\Models\Order;
use Illuminate\Database\Eloquent\Model;

class TableReservation extends Model
{
    use BaseModelTrait;

    public $incrementing = false;
    protected $perPage = 10;
    protected $keyType = 'string';

    protected $guarded = ['id'];
    protected $casts = ['is_open' => 'boolean'];

    public function order()
    {
        return $this->hasOne(Order::class);
    }
}
