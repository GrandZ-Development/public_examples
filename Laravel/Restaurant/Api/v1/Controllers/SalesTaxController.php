<?php


namespace App\Modules\Restaurant\Api\v1\Controllers;


use App\Modules\BaseController;
use App\Modules\Restaurant\Api\v1\Transformers\SalesTaxTransformer;
use App\Modules\Restaurant\Repositories\SalesTaxRepository;
use Dingo\Api\Http\Request;

/**
 * @group Sales Tax Management
 *
 * Class SalesTaxController
 * @package App\Modules\Restaurant\Api\v1\Controllers
 */
class SalesTaxController extends BaseController
{

    /**
     * @var SalesTaxRepository
     */
    protected $salesTaxRepository;

    /**
     * @var SalesTaxTransformer
     */
    protected $salesTaxTransformer;


    public function __construct(SalesTaxRepository $salesTaxRepository,
                                SalesTaxTransformer $salesTaxTransformer)
    {

        $this->salesTaxRepository = $salesTaxRepository;
        $this->salesTaxTransformer = $salesTaxTransformer;
    }


    /**
     * Create sales tax
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createSalesTax(Request $request){

        $data = $request->validate([
            'name' => 'required|unique:sales_taxes,name',
            'tax'   => 'required|numeric|min: 0.01'
        ]);


        $salesTax = $this->salesTaxRepository->persist($data);


        if(!$salesTax){
            return $this->error('Unable to create sales tax');
        }


        return  $this->transform($salesTax, $this->salesTaxTransformer);
    }


    /**
     * Update Sales tax
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateSalesTax(Request $request){

        $data = $request->validate([
            'id'    => 'required|exists:sales_taxes',
            'name' => 'required',
            'tax'   => 'required|numeric|min: 0.01'
        ]);



        $salesTax = $this->salesTaxRepository->findById($data['id']);

        if($this->salesTaxRepository->nameAlreadyExist($data['name'], $data['id'])){
            return $this->error('Sales tax already exist',422);
        }



        $updated = $this->salesTaxRepository->update($data['id'], $data);


        if($updated){
            return  $this->transform($salesTax->refresh(), $this->salesTaxTransformer);
        }

        return  $this->error('Unable to update sales tax');


    }


    /**
     * Delete Sales tax
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteSalesTax($id){


        if($this->salesTaxRepository->delete($id)){
            return $this->success(['message' => 'Sales tax deleted successfully']);
        }


        return  $this->error('Sales tax not found');
    }


    /**
     *
     * List sales taxes
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listSalesTax(){

        $salesTaxes = $this->salesTaxRepository->getSalesTax();

        return $this->transform($salesTaxes, $this->salesTaxTransformer);
    }


    /**
     * View sales Tax
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSalesTax($id){

        $salesTax  = $this->salesTaxRepository->findById($id);

        if(!$salesTax){
            return $this->error('Sales tax not found', 404);
        }


        return  $this->transform($salesTax, $this->salesTaxTransformer);

    }
}
