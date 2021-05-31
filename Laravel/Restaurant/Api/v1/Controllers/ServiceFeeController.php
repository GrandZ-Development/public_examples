<?php


namespace App\Modules\Restaurant\Api\v1\Controllers;


use App\Modules\BaseController;
use App\Modules\Restaurant\Api\v1\Transformers\ServiceFeeTransformer;
use App\Modules\Restaurant\Repositories\ServiceFeeRepository;
use Dingo\Api\Http\Request;


/**
 * @group Service fee management
 *
 * Class ServiceFeeController
 * @package App\Modules\Restaurant\Api\v1\Controllers
 */
class ServiceFeeController extends BaseController
{

    /**
     * @var ServiceFeeRepository
     */
    protected $serviceFeeRepository;

    /**
     * @var ServiceFeeTransformer
     */
    protected $serviceFeeTransformer;


    public function __construct(ServiceFeeRepository $serviceFeeRepository,
                                ServiceFeeTransformer $serviceFeeTransformer)
    {
        $this->serviceFeeRepository = $serviceFeeRepository;
        $this->serviceFeeTransformer = $serviceFeeTransformer;
    }


    /**
     * Create Fee
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createFee(Request $request){


        $data = $request->validate([
            'name' => 'required|unique:service_fees',
            'amount' => 'required|numeric|min:0.01'
        ], [
            'name' => 'Service fee already exist'
        ]);


        $serviceFee = $this->serviceFeeRepository->persist($data);


        return $this->transform($serviceFee, $this->serviceFeeTransformer);
    }


    /**
     * Update Fee
     *
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateFee(Request $request){

        $data = $request->validate([
            'id'     => 'required|exists:service_fees,id',
            'name'   => 'required',
            'amount' => 'required|numeric|min:0.01'
        ]);

        if($this->serviceFeeRepository->feeAlreadyExist($data['name'], $data['id'])){
            return  $this->error('Fee name already exist');
        }


        $serviceFee = $this->serviceFeeRepository->findById($data['id']);


        $updated = $this->serviceFeeRepository->update($data['id'], $data);

        if(!$updated){
            return $this->error('Error Updating service fee', 500);
        }

        return $this->transform($serviceFee, $this->serviceFeeTransformer);
    }


    /**
     * Delete Service fee
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteDelete($id){

        $serviceFee = $this->serviceFeeRepository->findById($id);

        if(!$serviceFee){
            return $this->error('Service fee not found', 404);
        }

        $deleted = $this->serviceFeeRepository->delete($id);
        if($deleted){
            return  $this->success(['message'=>'Service fee deleted']);
        }
        return  $this->error('Unable to delete service fee', 500);
    }


    /**
     * List Service fees
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listFees(){

        $fees = $this->serviceFeeRepository->getFees();

        return $this->transform($fees, $this->serviceFeeTransformer);

    }


    /**
     * View Service Fee
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getServiceFee($id){


        $fee = $this->serviceFeeRepository->findById($id);

        if(!$fee){
            return $this->error('Service fee not found');
        }


        return $this->transform($fee, $this->serviceFeeTransformer);

    }



}
