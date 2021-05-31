<?php


namespace App\Modules\Restaurant\Repositories;


use App\Modules\BaseRepository;
use App\Modules\Restaurant\Models\HolidayDay;
use App\Modules\Restaurant\Models\HolidayHour;
use DateInterval;
use DatePeriod;
use DateTime;

class HolidayDayRepository extends BaseRepository
{
    protected $start_time;

    protected $end_time;

    public function __construct(HolidayDay $holidayDay)
    {
        parent::__construct($holidayDay);
        $this->start_time = config('holidayHours.hours.DAY_CREATION_TIME.START_TIME');
        $this->end_time = config('holidayHours.hours.DAY_CREATION_TIME.END_TIME');
    }


    public function addDay(array $data)
    {

        $day = new HolidayDay();
        $day->name = $data['name'];
        $day->date = $data['date'];
        $day->save();

        $hours = new HolidayHour();
        $hours->day_id = $day->id;
        $hours->start_time = $data['start_time'];
        $hours->end_time = $data['end_time'];
        $hours->save();


        return 'Holiday days added successfully.';
    }

    public function listDays()
    {
        $days = HolidayDay::with('hours')->get();

        return $days;
    }

    public function deleteDay($data)
    {
        $id = $data['id'];

        $model = HolidayDay::where('id', $id);

        $model->delete();

        return 'Holiday day deleted successfully.';
    }

    public function updateDay($data)
    {

        $holiday = HolidayDay::where('id', $data['id'])->first();
        $holiday->name = $data['name'];
        $holiday->date = $data['date'];
        $holiday->save();
        $holiday_hour = HolidayHour::where('day_id', $data['id'])->firstOrFail();
        $holiday_hour->start_time = $data['start_time'];
        $holiday_hour->end_time = $data['end_time'];
        $holiday_hour->save();

        return $holiday_hour;
    }
    public function updateStatus($data)
    {

        $holiday = HolidayDay::where('id', $data['id'])->first();
        if ($holiday->closed == 1) {
            $holiday->closed = 0;
        } else {
            $holiday->closed = 1;
        }

        $holiday->save();

        return $holiday;
    }
}
