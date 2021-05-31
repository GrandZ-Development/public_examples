<?php


namespace App\Modules\Restaurant\Api\v1\Controllers;


use App\Modules\BaseController;
use App\Modules\Restaurant\Api\v1\Transformers\ItemMultipleChoiceTransformer;
use App\Modules\Restaurant\Repositories\ItemMultipleChoiceRepository;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\Storage;


/**
 * @group Item multiple choice
 *
 *
 * Class ItemMultipleChoiceController
 * @package App\Modules\Restaurant\Api\v1\Controllers
 */
class ItemMultipleChoiceController extends BaseController
{

    protected $itemMultipleChoiceRepository;

    protected $itemMultipleChoiceTransformer;


    public function __construct(ItemMultipleChoiceRepository $itemMultipleChoiceRepository,
                                ItemMultipleChoiceTransformer $itemMultipleChoiceTransformer)
    {

        $this->itemMultipleChoiceRepository = $itemMultipleChoiceRepository;
        $this->itemMultipleChoiceTransformer = $itemMultipleChoiceTransformer;
    }


    /**
     * Create Multiple Choice
     * @authenticated
     *
     * @bodyParam name string required Should be unique
     * @bodyParam options array required Must have atleast 2 items
     * @bodyParam image image required
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createMultipleChoice(Request $request){

        $data = $request->validate([
            'name' => 'required|unique:item_multiple_choices',
            'options' => 'required|array|min:2|distinct',
            'image'     => 'required',
            ],[
                'name.unique' => 'Multiple choice name already exist'
        ]);

        $data['options'] = json_encode($data['options']);

        $image = $request['image']['base64File'];

        $image_info = getimagesize($image);

        $extension = (isset($image_info["mime"]) ? explode('/', $image_info["mime"] )[1]: "");

        $type = 'data:image/'.$extension.';base64,';

        $image = str_replace($type, '', $image);
        $image = str_replace(' ', '+', $image);

        $imageName = 'image_'.time().'.'.$extension;
        \File::put(storage_path(). '/app/public/restaurant/item-multiple-choice/' . $imageName, base64_decode($image));

        $data['image'] = 'restaurant/item-multiple-choice/' .$imageName;

        $itemOption = $this->itemMultipleChoiceRepository->persist($data);

        if(!$itemOption){
            return $this->error('Failed to create Multiple choice, please try again',500);
        }

        return  $this->transform($itemOption, $this->itemMultipleChoiceTransformer);

    }

    /**
     * Update multiple choice
     * @authenticated
     *
     * @bodyParam name string required Should be unique
     * @bodyParam options array required Must have atleast 2 items
     * @bodyParam image image required
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateMultipleChoice(Request $request){

        $data = $request->validate([
            'id' => 'required|exists:item_multiple_choices',
            'name' => 'required',
            'options' => 'required|array|min:2|distinct',
            // 'image'     => 'required',
        ],[
            'name.unique' => 'Multiple choice name already exist'
        ]);

        $data['options'] = json_encode($data['options']);

        $image = $request['image']['base64File'];

        $image_info = getimagesize($image);

        $extension = (isset($image_info["mime"]) ? explode('/', $image_info["mime"] )[1]: "");

        $type = 'data:image/'.$extension.';base64,';

        $image = str_replace($type, '', $image);
        $image = str_replace(' ', '+', $image);

        $imageName = 'image_'.time().'.'.$extension;
        \File::put(storage_path(). '/app/public/restaurant/item-multiple-choice/' . $imageName, base64_decode($image));

        $data['image'] = 'restaurant/item-multiple-choice/' .$imageName;

        $updated = $this->itemMultipleChoiceRepository->update($data['id'],$data);

        if(!$updated){
            return $this->error('Failed to update Multiple choice, please try again',500);
        }


        $itemMultipleChoice = $this->itemMultipleChoiceRepository->findById($data['id']);

        return  $this->transform($itemMultipleChoice, $this->itemMultipleChoiceTransformer);

    }


    /**
     * List Item Multiple Choice
     * @authenticated
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listMultipleChoices(){
        $itemOptions = $this->itemMultipleChoiceRepository->getItemOptions();
        return $this->transform($itemOptions, $this->itemMultipleChoiceTransformer);
    }


    /**
     * Delete Item Multiple Choice
     * @authenticated
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function deleteMultipleChoice($id){
        $deleted =  $this->itemMultipleChoiceRepository->delete($id);

        if($deleted){
            return $this->success(['message' => 'Multiple choice deleted successfully']);
        }

        return  $this->error('Multiple choice not found', 404);
    }
}
