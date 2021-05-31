<?php


namespace App\Modules\Restaurant\Repositories;


use App\Modules\BaseRepository;
use App\Modules\Restaurant\Models\Table;
use Illuminate\Database\Eloquent\Model;

class TableRepository extends BaseRepository
{


    public function __construct(Table $model)
    {
        parent::__construct($model);
    }


    public function tableExistId($name, $id){
        return $this->model->where('name', $name)->where('id', '<>', $id)->count() > 0;
    }

    public function delete(string $id)
    {
        return Table::destroy($id);
    }


    public function getTables(){
        return $this->model->orderBy('name', 'ASC')->get();
    }

}
