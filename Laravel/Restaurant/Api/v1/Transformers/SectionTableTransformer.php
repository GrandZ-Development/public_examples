<?php


namespace App\Modules\Restaurant\Api\v1\Transformers;


use App\Modules\Restaurant\Models\Section;
use League\Fractal\TransformerAbstract;
use Spatie\Fractalistic\ArraySerializer;

class SectionTableTransformer extends TransformerAbstract
{


    public function transform(Section $section){
        return [
            'id' => $section->id,
            'name' => $section->name,
            'floor_id' => $section->floor_id,
            'tables' => fractal($section->tables, new TableTransformer())->serializeWith(new ArraySerializer())->toArray()
        ];
    }
}
