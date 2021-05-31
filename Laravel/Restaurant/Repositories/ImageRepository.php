<?php


namespace App\Modules\Restaurant\Repositories;



use App\Modules\BaseRepository;
use App\Modules\Restaurant\Models\Image;

class ImageRepository extends BaseRepository
{
    public function __construct(Image $model)
    {
        parent::__construct($model);
    }

    public function get()
    {
        $query = $this->model->newQuery();
        $type = request('type');
        if ($type)
            $query->where('type', $type);

        return $query->get();
    }

    public function store($attributes)
    {

        return $this->model->create([
            'type' => $attributes['type'],
            'image' => store_base64($attributes['image'], 'images/restaurant')
        ]);
    }
}
