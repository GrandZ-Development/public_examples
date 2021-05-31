<?php


namespace App\Modules\Restaurant\Api\v1\Controllers;


use App\Modules\BaseController;
use App\Modules\Restaurant\Api\v1\Requests\CreateItemRequest;
use App\Modules\Restaurant\Api\v1\Requests\UpdateItemRequest;
use App\Modules\Restaurant\Api\v1\Resources\ItemResource;
use App\Modules\Restaurant\Api\v1\Transformers\ItemTransformer;
use App\Modules\Restaurant\Repositories\ItemRepository;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\Storage;


/**
 * @group Item/Slide/Upsells Management
 *
 * Class ItemController
 * @package App\Modules\Restaurant\Api\v1\Controllers
 */
class ItemController extends BaseController
{


    /**
     * @var ItemRepository
     */
    protected $itemRepository;


    /**
     * @var ItemTransformer
     */
    protected $itemTransformer;


    public function __construct(ItemRepository $itemRepository,
                                ItemTransformer $itemTransformer)
    {
        $this->itemRepository = $itemRepository;
        $this->itemTransformer = $itemTransformer;
    }


    /**
     * Create Item
     * @authenticated
     *
     * @bodyParam price numeric required Min value of 0.01
     * @bodyParam take_out_price numeric required Min value of 0.01
     * @bodyParam delivery_price numeric required Min value of 0.01
     * @bodyParam has_price boolean required
     *
     * @param CreateItemRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createItem(CreateItemRequest $request){


        $data = $request->validated();


        if($this->itemRepository->itemExist($data['name'], $data['type'])){
            return $this->error(ucfirst($data['type']).' Already exists');
        }


        if(isset($data['additional_fees'])){
            $data['additional_fees'] = json_encode(collect($data['additional_fees'])->unique('fee_id')->toArray());
        }
        if(isset( $data['ingredients'])){
            $data['ingredients'] = json_encode(collect($data['ingredients'])->unique('ingredient_id')->toArray());
        }

        if(isset($data['upsells'])){
            $data['upsells'] = json_encode(collect($data['upsells'])->unique('upsell_id')->toArray());
        }

        if(isset($data['sides'])){
            $data['sides'] = json_encode(collect($data['sides'])->unique('side_id')->toArray());
        }


        if(isset($data['multiple_choices'])){
            $data['multiple_choices'] = json_encode(collect($data['multiple_choices'])->unique('choice_id')->toArray());
        }

        if(isset($data['toppings'])){
            $data['toppings'] = json_encode(collect($data['toppings'])->unique('topping_id')->toArray());
        }


        if( !empty($data['availability'])){
            $data['availability'] = implode(',', $data['availability']);
        }


        if($request->has('image')){
            $filename =  $this->getFileName($request->file('image'), 'item');
            $data['image'] = $request->file('image')->storeAs('restaurant/item',$filename,'public');
        }

        $data['price'] = (empty($data['price'])) ? 0 : $data['price'];

        $data['take_out_price'] = (empty($data['take_out_price'])) ? 0 : $data['take_out_price'];

        $data['delivery_price'] = (empty($data['delivery_price'])) ? 0 : $data['delivery_price'];

        $item = $this->itemRepository->persist($data);
        return  $this->transform($item, $this->itemTransformer);

    }


    /**
     * Resturant/Food List Items
     * @authenticated
     *
     * @bodyParam item_type string required (item for food, toppings, beverages, upsell, side )
     * @bodyParam category_id string optional id of the category to filter results

     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listItems(Request $request){
        $request->validate(['type' =>'required']);


        $items = $this->itemRepository->listItems($request->all());

        return $this->transform($items, $this->itemTransformer);
    }


    /**
     * View Item
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getItem($id){


        $item = $this->itemRepository->findById($id);

        if(!$item){
            return $this->error('Item xnot found', 404);
        }


        return  $this->transform($item, $this->itemTransformer);
    }


    /**
     * Delete Item
     * @authenticated
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteItem($id){
        $item = $this->itemRepository->findById($id);

        if(!$item){
            return $this->error('Item not found', 404);
        }


        if(file_exists(storage_path('app/public/'.$item->image))){
            Storage::disk('public')->delete($item->image);
        }


        $deleted  = $this->itemRepository->delete($id);

        if(!$deleted){
            return $this->error('Unable to delete '.ucfirst($item->type));
        }

        return  $this->success(['message' => 'Item deleted successfully']);
    }


    /**
     * Update Item
     * @authenticated
     *
     * @bodyParam price numeric required Min value of 0.01
     * @bodyParam take_out_price numeric required Min value of 0.01
     * @bodyParam delivery_price numeric required Min value of 0.01
     * @bodyParam has_price boolean required
     *
     * @param UpdateItemRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateItem(UpdateItemRequest $request){


        $data = $request->validated();

        $item = $this->itemRepository->findById($data['id']);

        if(!$item){
            return $this->error('Item not found', 404);
        }


        if($this->itemRepository->itemExist($data['name'], $data['type'], $data['id'])){
            return $this->error(ucfirst($data['type']).' Already exists');
        }


        if(isset($data['additional_fees'])){
            $data['additional_fees'] = json_encode(collect($data['additional_fees'])->unique('fee_id')->toArray());
        }
        if(isset( $data['ingredients'])){
            $data['ingredients'] = json_encode(collect($data['ingredients'])->unique('ingredient_id')->toArray());
        }

        if(isset($data['upsells'])){
            $data['upsells'] = json_encode(collect($data['upsells'])->unique('upsell_id')->toArray());
        }

        if(isset($data['sides'])){
            $data['sides'] = json_encode(collect($data['sides'])->unique('side_id')->toArray());
        }

        if(isset($data['multiple_choices'])){
            $data['multiple_choices'] = json_encode(collect($data['multiple_choices'])->unique('choice_id')->toArray());
        }

        if(isset($data['toppings'])){
            $data['toppings'] = json_encode(collect($data['toppings'])->unique('topping_id')->toArray());
        }

        if( !empty($data['availability'])){
            $data['availability'] = implode(',', $data['availability']);
        }

        if($request->has('image')){
            $filename =  $this->getFileName($request->file('image'), 'item');
            $data['image'] = $request->file('image')->storeAs('restaurant/item',$filename,'public');
        }

        if ($data['type'] == 'side' || $data['type'] == 'toppings') {
            if ($data['has_price'] == 0) {
                Storage::disk('local')->put('example.txt', 'Done');
                $data['price'] = 0.00;
                $data['take_out_price'] = 0.00;
                $data['delivery_price'] = 0.00;
            }
        }

        $updated = $this->itemRepository->update($data['id'],$data);

        if(!$updated){
            return  $this->error(' Unable to update '.ucfirst($data['type']));
        }


        return  $this->transform($item->refresh(), $this->itemTransformer);
    }

    /**
     * Toggle Out of stock
     * @authenticated
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function outOfStock($id){
        $item = $this->itemRepository->findById($id);

        if(!$item){
            return $this->error('Item not found', 404);
        }

        $updated = $item->toggleOutOfStock();

        if(!$updated){
            return $this->error('Unable to update '.ucfirst($item->type));
        }

        return  $this->success(['message' => 'Item updated successfully']);
    }

    /**
     * Get Category Items
     * @authenticated
     *
     * @param $categoryId
     */

    public function listCategoryItems($categoryId)
    {
        return ItemResource::collection($this->itemRepository->listItems(['category_id' => $categoryId]));
    }

    /**
     * Get Items by type
     * @authenticated
     * [type: side, toppings, upsell]
     *
     * @param $type
     * @return
     */

    public function listItemsByType($type)
    {
        return ItemResource::collection($this->itemRepository->listItems(['type' => $type]));
    }

}
