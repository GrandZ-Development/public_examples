<?php


namespace App\Modules\Restaurant\Api\v1\Transformers;


use App\Modules\Restaurant\Models\Floor;
use League\Fractal\TransformerAbstract;
use Spatie\Fractalistic\ArraySerializer;

class FloorTransformer extends TransformerAbstract
{


    public function transform(Floor $model){
        return [
            'id'        => $model->id,
            'name'      => $model->name,
//            'size'      => $model->size,
            'sections'    => fractal($model->sections, new SectionTableTransformer())->serializeWith(new ArraySerializer())->toArray()
        ];

    }
}
