<?php


namespace App\Modules\Restaurant\Api\v1\Controllers;


use App\Modules\BaseController;
use App\Modules\Restaurant\Api\v1\Requests\CreateSideRequest;
use App\Modules\Restaurant\Api\v1\Requests\UpdateSideRequest;
use App\Modules\Restaurant\Api\v1\Transformers\SideTransformer;
use App\Modules\Restaurant\Repositories\SideRepository;
use Illuminate\Support\Facades\Storage;


/**
 * @group Side Management
 *
 *
 * Class SideController
 * @package App\Modules\Restaurant\Api\v1\Controllers
 */
class SideController extends BaseController
{

    /**
     * @var SideRepository
     */
    protected $sideRepository;


    protected $sideTransformer;

    public function __construct(SideRepository $sideRepository, SideTransformer $sideTransformer)
    {
        $this->sideRepository = $sideRepository;
        $this->sideTransformer = $sideTransformer;
    }


    /**
     * Create Side
     * @authenticated
     *
     * @param CreateSideRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createSide(CreateSideRequest $request){


        $data = $request->validated();
        if(isset($data['additional_fees'])){
            $data['additional_fees'] = json_encode(collect($data['additional_fees'])->unique('fee_id')->toArray());
        }
        if(isset( $data['ingredients'])){
            $data['ingredients'] = json_encode(collect($data['ingredients'])->unique('ingredient_id')->toArray());
        }

        $data['availability'] = implode(',', $data['availability']);

        if($request->has('image')){
            $filename =  $this->getFileName($request->file('image'), 'item');
            $data['image'] = $request->file('image')->storeAs('restaurant/item',$filename,'public');
        }






        $side = $this->sideRepository->persist($data);

        if(!$side){
            return  $this->error('Unable to create side', 500);
        }

        return $this->transform($side, $this->sideTransformer);

    }


    /**
     * List Sides
     * @authenticated
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listSides(){

        $sides = $this->sideRepository->listSides();
        return $this->transform($sides, $this->sideTransformer);
    }


    /**
     * Update Side
     * @authenticated
     *
     * @param UpdateSideRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateSide(UpdateSideRequest $request){



        $data = $request->validated();

        $side =  $this->sideRepository->findById($data['id']);

        if(!$side){
            return  $this->error('Unable to update a non existent side',404);
        }



        if(isset($data['additional_fees'])){
            $data['additional_fees'] = json_encode(collect($data['additional_fees'])->unique('fee_id')->toArray());
        }

        if(isset( $data['ingredients'])){
            $data['ingredients'] = json_encode(collect($data['ingredients'])->unique('ingredient_id')->toArray());
        }
        $data['availability'] = implode(',', $data['availability']);


        if($request->has('image')){
            $filename =  $this->getFileName($request->file('image'), 'item');
            $data['image'] = $request->file('image')->storeAs('restaurant/item',$filename,'public');
            //Delete old file
            if(file_exists(storage_path('app/public/'.$side->image))){
                Storage::disk('public')->delete($side->image);
            }
        }



       $updated = $this->sideRepository->update($data['id'], $data);


       if($updated){
           $side = $this->sideRepository->findById($data['id']);

           return $this->transform($side, $this->sideTransformer);
       }


       return $this->error('Unable to update side at the moment', 500);

    }


    /**
     * Delete Slide
     * @authenticated
     *
     *
     * @param $id
     */
    public function deleteSide($id){

        if(!$this->sideRepository->findById($id)){
            return $this->error('Can not delete a non existent side');
        }

        $deleted  = $this->sideRepository->delete($id);

        if($deleted){
            return  $this->success(['message' => 'Side deleted successfully']);
        }

        return $this->error('Unable to delete side');


    }


    /**
     * View Side
     * @authenticated
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSide($id){

        $side =  $this->sideRepository->findById($id);

        if(!$side){
            return $this->error('Side not found');
        }

        return $this->transform($side, $this->sideTransformer);
    }

}
