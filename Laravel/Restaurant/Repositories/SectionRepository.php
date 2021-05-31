<?php


namespace App\Modules\Restaurant\Repositories;


use App\Modules\BaseRepository;
use App\Modules\Restaurant\Models\Section;
use App\Modules\Restaurant\Models\SectionTable;
use Illuminate\Database\Eloquent\Model;

class SectionRepository extends BaseRepository
{


    public function __construct(Section $model)
    {
        parent::__construct($model);
    }


    public function sectionAlreadyExist($name,$id){
        return $this->model->where('name', $name)->where('id', '<>', $id)->count() > 0;
    }


    public function addTable(array $data){
        return SectionTable::updateOrcreate($data);
    }


    public function removeTable(array $data){
        return SectionTable::where('table_id',$data['table_id'])
            ->where('section_id', $data['section_id'])
            ->delete();
    }

    public function getTableSection($tableId, $sectionId){
        return SectionTable::where('table_id',$tableId)
            ->where('section_id', $sectionId)
            ->first();
    }


}
