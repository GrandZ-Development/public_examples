<?php

namespace App\Modules\Restaurant\Models;

use App\Modules\BaseModelTrait;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use BaseModelTrait;

    public $incrementing = false;


    protected $fillable = ['name', 'slug', 'floor_id'];


//    public function tables(){
//        return $this->hasManyThrough(Table::class, SectionTable::class, 'section_id','id','id', 'table_id');
//    }

    public function tables(){

        return $this->hasMany(Table::class,'section_id');
    }

}
