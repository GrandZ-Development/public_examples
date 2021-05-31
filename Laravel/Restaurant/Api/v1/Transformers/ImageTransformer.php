<?php


namespace App\Modules\Restaurant\Api\v1\Transformers;


use App\Modules\Restaurant\Models\Image;

use League\Fractal\TransformerAbstract;

class ImageTransformer extends TransformerAbstract
{


    public function transform(Image $model){
        return [
            'id'        => $model->id,
            'type'      => $model->type,
            'image'      => $model->image_path,
        ];

    }
}
