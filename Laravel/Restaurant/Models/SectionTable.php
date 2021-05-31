<?php

namespace App\Modules\Restaurant\Models;

use App\Modules\BaseModelTrait;
use Illuminate\Database\Eloquent\Model;

class SectionTable extends Model
{
    public $incrementing  =  false;

    protected $fillable = ['section_id', 'table_id',];

    protected $with = ['table'];

    use BaseModelTrait;


    public function table(){
        return $this->belongsTo(Table::class);
    }
}
