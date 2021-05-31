<?php


namespace App\Modules\Restaurant\Api\v1\Controllers;



use App\Modules\BaseController;
use App\Modules\Restaurant\Api\v1\Requests\CreateHourRequest;
use App\Modules\Restaurant\Api\v1\Requests\UpdateHourRequest;
use App\Modules\Restaurant\Api\v1\Transformers\BusinessHourTransformer;
use App\Modules\Restaurant\Repositories\BusinessHourRepository;
use Carbon\Carbon;


/**
 * @group Business Hour Management
 *
 * Class BusinessHoursControllers
 * @package App\Modules\Restaurant\Api\v1\Controllers
 */
class BusinessHoursControllers extends BaseController
{

    /**
     * @var BusinessHourRepository
     */
    protected $businessHourRepository;


    /**
     * @var BusinessHourTransformer
     */
    protected $businessHourTransformer;


    public function __construct(BusinessHourRepository $businessHourRepository, BusinessHourTransformer  $businessHourTransformer)
    {

        $this->businessHourRepository =  $businessHourRepository;
        $this->businessHourTransformer = $businessHourTransformer;
    }


    /**
     * Add Business Hour
     * @authenticated
     *
     * @bodyParam day string required Days between Sunday to Saturday
     * @bodyParam start_time string required Business opening hours in format of HOUR:MINUTE e.g 13:00 or 1:00 pm
     * @bodyParam end_time string required Business closing hours in format of HOUR:MINUTE e.g 13:00 or 1:00 pm
     * @bodyParam close string optional If if Business time is closed
     *
     * @param CreateHourRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createHour(CreateHourRequest $request){

        $data = $request->validated();

        //Normalize to 24 hours
        $data['start_time'] = Carbon::parse($data['start_time'])->format('H:i');
        $data['end_time']   = Carbon::parse($data['end_time'])->format('H:i');

        $data['day_index'] = $this->getDayIndex($data['day']);

        $hour = $this->businessHourRepository->addTime($data);
        return $this->transform($hour, $this->businessHourTransformer);

    }

    /**
     * List business Hours
     * @authenticated
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listHours(){
        $hours = $this->businessHourRepository->getBusinessHours();

        return $this->transform($hours, $this->businessHourTransformer);
    }


    /**
     * Update Business Hour
     * @authenticated
     *
     * @bodyParam id string required Business hour id
     * @bodyParam day string required Days between Sunday to Saturday
     * @bodyParam start_time string required Business opening hours in format of HOUR:MINUTE e.g 13:00 or 1:00 pm
     * @bodyParam end_time string required Business closing hours in format of HOUR:MINUTE e.g 13:00 or 1:00 pm
     * @bodyParam close string optional If if Business time is closed
     *
     *
     * @param UpdateHourRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateBusinessHour(UpdateHourRequest $request){

        $data = $request->validated();

        if($this->businessHourRepository->dayAlreadyExist($data['day'], $data['id'])){
            return  $this->error('Day already exist', 422);
        }



        //Normalize to 24 hours
        $data['start_time'] = Carbon::parse($data['start_time'])->format('H:i');
        $data['end_time']   = Carbon::parse($data['end_time'])->format('H:i');
        $data['day_index'] = $this->getDayIndex($data['day']);

        $updated = $this->businessHourRepository->update($data['id'], $data);

        if($updated){
            $hour = $this->businessHourRepository->findById($data['id']);

            return $this->transform($hour, $this->businessHourTransformer);
        }


        return  $this->error('Unable to update business hour');

    }


    /**
     * Delete Business hours
     * @authenticated
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteHour(string $id){
        if(!$this->businessHourRepository->findById($id)){
            return $this->error('Business hour not found', 404);
        }

        $deleted = $this->businessHourRepository->delete($id);

        if($deleted){
            return  $this->success(['message' => 'Business hour deleted successfully']);
        }
        return $this->error('Unable to delete business hour', 500);
    }

    private function getDayIndex($day){
        $daysIndex = [
            'monday'    => 1,
            'tuesday'   => 2,
            'wednesday' => 3,
            'thursday'  => 4,
            'friday'    => 5,
            'saturday'  => 6,
            'sunday'    => 7
        ];

        return $daysIndex[$day];
    }
}
