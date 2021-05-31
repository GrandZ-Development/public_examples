<?php

namespace App\Modules\Restaurant\Models;

use App\Modules\BaseModelTrait;
use App\Modules\Order\Models\Order;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use BaseModelTrait;

    public $incrementing = false;
    protected $primaryKey = 'id';

    protected $guarded = ['id'];

    protected $casts = ['can_merge' => 'boolean', 'no_of_seats', 'position' => 'array'];

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }
    public function seats()
    {
        return $this->hasMany(Seat::class);
    }


    public function getOrderAttribute(){
       return  Order::where('fulfilment_status', 'pending')->where('table_id', $this->id)->with('items.item')->first();
    }

    public function reservations()
    {
        return $this->hasMany(TableReservation::class, 'table_id');
    }

    public function open_reservation()
    {
        return $this->hasOne(TableReservation::class, 'table_id')->where('is_open', true);
    }
    public function scopeNotOpened($query)
    {
        return$query->whereDoesntHave('open_table');
    }
}
