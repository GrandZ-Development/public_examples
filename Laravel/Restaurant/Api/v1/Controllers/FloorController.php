<?php


namespace App\Modules\Restaurant\Api\v1\Controllers;


use App\Modules\BaseController;
use App\Modules\Restaurant\Api\v1\Requests\CreateFloorRequest;
use App\Modules\Restaurant\Api\v1\Requests\StoreFloorRequest;
use App\Modules\Restaurant\Api\v1\Requests\UpdateFloorRequest;
use App\Modules\Restaurant\Api\v1\Resources\FloorResource;
use App\Modules\Restaurant\Api\v1\Transformers\FloorTransformer;
use App\Modules\Restaurant\Repositories\FloorRepository;
use App\Modules\Restaurant\Repositories\ImageRepository;
use Dingo\Api\Http\Request;


/**
 *  @group Floor Management
 *
 *
 *
 * @package App\Modules\Restaurant\Api\v1\Controllers
 */
class FloorController extends BaseController
{

    /**
     * @var FloorRepository
     */
    protected $floorRepository;
/**
     * @var FloorRepository
     */
    protected $imageRepository;


    /**
     * @var FloorTransformer
     */
    protected $floorTransformer;



    public function __construct(FloorRepository $floorRepository,
                                ImageRepository $imageRepository,
                                FloorTransformer $floorTransformer)
    {
        $this->floorRepository = $floorRepository;
        $this->floorTransformer = $floorTransformer;
        $this->imageRepository = $imageRepository;
    }


    /**
     * Create Or Update Floor
     * @authenticated
     * [This is do both update or create the floor. To update the floor Id field is required]
     *
     * @bodyParam id string optional Needed when to update
     * @bodyParam name string required Floor Name
     *
     * @transformer FloorTransformer
     */
    
    public function store(StoreFloorRequest $request){

        $data = $request->validated();
        $table = $this->floorRepository->updateOrCreate([
            'id' => $data['id'] ?? null,
            'name' => $data['name'],
//            'size' => $data['size'],
        ]);

        return $this->transform($table,$this->floorTransformer);

    }


    /**
     * List tables
     * @authenticated
     *
     * @param Request $request
     * @transformerCollection FloorTransformer
     */
    public function listFloors(){

        $data = $this->floorRepository->list();

        return $this->transform($data, $this->floorTransformer);

    }

    /**
     * Delete Floor
     * @authenticated
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteFloor($id){

        $this->floorRepository->delete($id);
        return $this->success(['message' => 'Floor deleted successfully']);
    }
    /**
     * Get Floor Plan
     * @authenticated
     * @return FloorResource
     */
    public function getFloorPlan()
    {
        return FloorResource::collection($this->floorRepository->getFloorPlan());
    }
}
