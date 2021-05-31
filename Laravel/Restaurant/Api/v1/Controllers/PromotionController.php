<?php


namespace App\Modules\Restaurant\Api\v1\Controllers;


use App\Modules\BaseController;
use App\Modules\Restaurant\Api\v1\Requests\CreatePromotionRequest;
use App\Modules\Restaurant\Api\v1\Requests\UpdatePromotionRequest;
use App\Modules\Restaurant\Api\v1\Transformers\PromotionTransformer;
use App\Modules\Restaurant\Repositories\PromotionRepository;


/**
 * @group Coupons and Promotions management
 *
 * Class PromotionController
 * @package App\Modules\Restaurant\Api\v1\Controllers
 */
class PromotionController extends BaseController
{

    protected $promotionRepository;
    protected $promotionTransformer;


    public function __construct(PromotionRepository $promotionRepository, PromotionTransformer $promotionTransformer)
    {
        $this->promotionRepository = $promotionRepository;
        $this->promotionTransformer = $promotionTransformer;
    }


    /**
     * Create Promotion
     * @param CreatePromotionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createPromotion(CreatePromotionRequest $request){

        $data = $request->validated();


        if(isset($data['items'])){
            $data['items'] = json_encode($data['items']);
        }

        $promotion = $this->promotionRepository->persist($data);

        return $this->transform($promotion, $this->promotionTransformer);

    }


    /**
     * Update Promotion
     *
     * @param UpdatePromotionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePromotion(UpdatePromotionRequest $request){

        $data = $request->validated();

        $promotion = $this->promotionRepository->findById($data['id']);

        if(!$promotion){
            return $this->error('Unable to update a none existent promotion',404);
        }

        if(isset($data['items'])){
            $data['items'] = json_encode($data['items']);
        }


        $updated = $this->promotionRepository->update($data['id'], $data);

        if($updated){
            return  $this->transform($promotion->refresh(), $this->promotionTransformer);
        }
        return  $this->error('Unable to update promotion', 500);

    }


    /**
     * Delete Promotion
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deletePromotion($id){


        if($this->promotionRepository->delete($id)){
            return $this->success(['message' => 'Promotion deleted successfully']);
        }


        return  $this->error('Promotion not found', 404);

    }


    /**
     * List Promotions
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listPromotions(){
        $promotions = $this->promotionRepository->getPromotions();
        return $this->transform($promotions, $this->promotionTransformer);

    }


    /**
     * View Promotion
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPromotion($id){

        $promotion = $this->promotionRepository->findById($id);

        if(!$promotion){
            return $this->error('Promotion not found',404);
        }


        return  $this->transform($promotion, $this->promotionTransformer);
    }
}
