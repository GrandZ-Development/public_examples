<?php


namespace App\Modules\Restaurant\Api\v1\Controllers;


use App\Modules\BaseController;
use App\Modules\Restaurant\Api\v1\Requests\StoreSeatRequest;
use App\Modules\Restaurant\Api\v1\Requests\UpdateSeatRequest;
use App\Modules\Restaurant\Api\v1\Transformers\SeatTransformer;
use App\Modules\Restaurant\Repositories\TableRepository;
use App\Modules\Restaurant\Repositories\SeatRepository;
use phpDocumentor\Reflection\Types\Nullable;

/**
 *  @group Seat Management
 *
 *
 *
 * @package App\Modules\Restaurant\Api\v1\Controllers
 */
class SeatController extends BaseController
{

    /**
     * @var SeatRepository
     */
    protected $seatRepository;

/**
     * @var TableRepository
     */
    protected $tableRepository;


    /**
     * @var SeatTransformer
     */
    protected $seatTransformer;



    public function __construct(SeatRepository $seatRepository,
                                TableRepository $tableRepository,
                                SeatTransformer $seatTransformer)
    {
        $this->seatRepository = $seatRepository;
        $this->seatTransformer = $seatTransformer;
        $this->tableRepository = $tableRepository;
    }


    /**
     * Create Or Update Seat
     * @authenticated
     *
     * @bodyParam id string optional Id
     * @bodyParam table_id string required Table Id
     * @bodyParam name string required Seat Name
     *
     *
     *
     * @param StoreSeatRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateOrCreate(StoreSeatRequest $request){
        $maxSeat = 10;

        $table = $this->tableRepository->findById($request->table_id);
        $seatsCount = $table->seats->count();
        if (! $request->id && $seatsCount > $maxSeat)
            return $this->error("Maximum seats limit is $maxSeat", 406);

        $seat = $this->seatRepository->updateOrCreate([
            'id' => $request->id ?? null,
            'table_id' => $table->id,
            'name' => $request->name
        ]);

        return $this->transform($seat,$this->seatTransformer);

    }

    /**
     * Create Seat
     * @authenticated
     *
     * @bodyParam table_id string required Table Id
     * @bodyParam name string required Seat Name
     *
     *
     *
     * @param StoreSeatRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createSeat(StoreSeatRequest $request){

        $table = $this->tableRepository->findById($request->table_id);
        $seat = $this->seatRepository->persist([
            'table_id' => $table->id,
            'name' => $request->name
        ]);

        return $this->transform($seat,$this->seatTransformer);

    }


    /**
     * List tables
     * @authenticated
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listSeats(){

        $data = $this->seatRepository->paginate();

        return $this->transform($data, $this->seatTransformer);

    }


    /**
     * Update Seat
     * @authenticated
     *
     * @bodyParam id string  required Seat id
     * @bodyParam name string Seat Name
     *
     *
     *
     * @param UpdateSeatRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateSeat(UpdateSeatRequest $request){


        $data = $request->validated();

        $updated =  $this->seatRepository->update($data['id'], $data);

        if($updated){
            $seat = $this->seatRepository->findOrFail($data['id']);
            return  $this->transform($seat, $this->seatTransformer);
        }

        return $this->fail('Seat update failed', 422);

    }


    /**
     * Delete Seat
     * @authenticated
     *
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteSeat($id){

        $this->seatRepository->delete($id);
        return $this->success(['message' => 'Seat deleted successfully']);
    }
}
