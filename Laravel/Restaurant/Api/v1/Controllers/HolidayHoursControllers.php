<?php


namespace App\Modules\Restaurant\Api\v1\Controllers;



use App\Modules\BaseController;
use App\Modules\Restaurant\Api\v1\Requests\CreateHolidayDaysRequest;
use App\Modules\Restaurant\Api\v1\Requests\DeleteHolidayDayRequest;
use App\Modules\Restaurant\Api\v1\Requests\UpdateHolidayHoursRequest;
use App\Modules\Restaurant\Api\v1\Requests\UpdateHolidayStatusRequest;
use App\Modules\Restaurant\Api\v1\Transformers\HolidayHourTransformer;
use App\Modules\Restaurant\Repositories\HolidayDayRepository;
use App\Modules\Restaurant\Repositories\HolidayHourRepository;


/**
 * @group Holiday Days Management
 *
 * Class HolidayHoursControllers
 * @package App\Modules\Restaurant\Api\v1\Controllers
 */
class HolidayHoursControllers extends BaseController
{

    /**
     * @var holidayHourRepository
     */
    protected $holidayHourRepository;

    /**
     * @var holidayDayRepository
     */
    protected $holidayDayRepository;

    /**
     * @var holidayHourTransformer
     */
    protected $holidayHourTransformer;

    /**
     *
     * HolidayHoursControllers constructor.
     * @param HolidayHourRepository $holidayHourRepository
     * @param HolidayDayRepository $holidayDayRepository
     * @param HolidayHourTransformer $holidayHourTransformer
     */
    public function __construct(HolidayHourRepository $holidayHourRepository,
                                HolidayDayRepository $holidayDayRepository,
                                HolidayHourTransformer $holidayHourTransformer
    )
    {
        $this->holidayHourRepository =  $holidayHourRepository;
        $this->holidayDayRepository =  $holidayDayRepository;
        $this->holidayHourTransformer =  $holidayHourTransformer;
    }

    /**
     * Add Holiday Days (By default, holiday days are stored in the range from: 00:00:00 to: 23:59:59)
     * @authenticated
     *
     * @bodyParam start_date string required Date range (start date) in format Y-m-d
     * @bodyParam end_date string required Date range (end date) in format Y-m-d
     *
     * @param CreateHolidayDaysRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createDay(CreateHolidayDaysRequest $request)
    {
        $data = $request->validated();
        $result = $this->holidayDayRepository->addDay($data);
        return empty($result) ? $this->error(['message' => 'Error while adding days']) : $this->success(['message' => 'Holiday days added successfully.']);
    }

    /**
     * Receive Holiday Days list
     * @authenticated
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listDays()
    {
        $results = $this->holidayDayRepository->listDays();

        return $this->transform($results, $this->holidayHourTransformer);
    }

    /**
     * Delete Holiday Day by id
     * @authenticated
     *
     * @bodyParam id string required Holiday day id
     *
     * @param DeleteHolidayDayRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteDay(DeleteHolidayDayRequest $request)
    {
        $data = $request->validated();

        $result = $this->holidayDayRepository->deleteDay($data);

        return empty($result) ? $this->error(['message' => 'Error while deleting holiday days']) : $this->success(['message' => 'Holiday days deleted successfully.']);
    }

    /**
     * Update Holiday Day hours by id
     * @authenticated
     *
     * @bodyParam id         string required Holiday day id
     * @bodyParam start_time string required The start time of a specific holiday day in format (hh:mm:ss) 09:21:33
     * @bodyParam end_time   string required The end time of a specific holiday day in format (hh:mm:ss) 09:21:33
     *
     * @param UpdateHolidayHoursRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateHours(UpdateHolidayStatusRequest $request)
    {
        $data = $request->validated();

        $result = $this->holidayDayRepository->updateDay($data);

        return empty($result) ? $this->error(['message' => 'Error while updating holiday day']) : $this->success(['message' => 'Holiday day updated successfully.']);
    }
 /**
     * Update Holiday Status hours by id
     * @authenticated
     *
     * @bodyParam id         string required Holiday day id
     
     *
     * @param UpdateHolidayStatusRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(UpdateHolidayStatusRequest $request)
    {
        $data = $request->validated();

        $result = $this->holidayDayRepository->updateStatus($data);

        return empty($result) ? $this->error(['message' => 'Error while updating holiday days']) : $this->success(['message' => 'Holiday day hours updated successfully.']);
    }

}
