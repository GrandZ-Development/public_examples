<?php


namespace App\Modules\Restaurant\Api\v1\Controllers;


use App\Modules\BaseController;
use App\Modules\Restaurant\Api\v1\Requests\CreateImageRequest;
use App\Modules\Restaurant\Api\v1\Transformers\ImageTransformer;
use App\Modules\Restaurant\Repositories\ImageRepository;
use Dingo\Api\Http\Request;


/**
 *  @group Image Management
 *
 *
 *
 * @package App\Modules\Restaurant\Api\v1\Controllers
 */
class ImageController extends BaseController
{

    /**
     * @var ImageRepository
     */
    protected $imageRepository;


    /**
     * @var ImageTransformer
     */
    protected $imageTransformer;



    public function __construct(ImageRepository $imageRepository,
                                ImageTransformer $imageTransformer)
    {
        $this->imageRepository = $imageRepository;
        $this->imageTransformer = $imageTransformer;
    }


    /**
     * Create Image
     * @authenticated
     *
     * @bodyParam name string required Image Name
     *
     *
     *
     * @param CreateImageRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createImage(CreateImageRequest $request){

        $data = $request->validated();

        $table = $this->imageRepository->store($data);

        return $this->transform($table,$this->imageTransformer);

    }


    /**
     * List tables
     * @authenticated
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listImages(){

        $data = $this->imageRepository->get();

        return $this->transform($data, $this->imageTransformer);

    }



    /**
     * Delete Image
     * @authenticated
     *
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteImage($id){

        $this->imageRepository->delete($id);
        return $this->success(['message' => 'Image deleted successfully']);
    }
}
