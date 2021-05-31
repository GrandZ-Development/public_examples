<?php

namespace App\Modules\Restaurant\Api\v1\Controllers;

use App\Modules\Restaurant\Api\v1\Requests\CreateReservationRequest;
use App\Modules\Restaurant\Api\v1\Resources\TableReservationResource;
use App\Modules\Restaurant\Repositories\TableReservationRepository;
use App\Modules\BaseController;

/**
 *  @group Table Reservation Management
 *
 *
 *
 * @package App\Modules\Restaurant\Api\v1\Controllers
 */

class TableReservationController extends BaseController
{
    /**
     * @var TableReservationRepository
     */
    protected $tableReservationRepository;

    public function __construct(TableReservationRepository $tableReservationRepository)
    {
        $this->tableReservationRepository = $tableReservationRepository;
    }

    /**
     * Create Table Reservation / Open a Table
     * @authenticated
     *
     * @bodyParam table_id string required
     * @bodyParam no_of_seats integer  required Should be <= tables seats
     *
     * @param CreateReservationRequest $request
     * @return TableReservationResource
     */

    public function create(CreateReservationRequest $request)
    {
        return (new TableReservationResource(
            $this->tableReservationRepository->persist([
                'opened_by' => auth()->user()->employee->id,
                'table_id' => $request->table_id,
                'no_of_seats' => $request->no_of_seats,
            ])
        ))->additional(['message' => 'Table Opened']);
    }

    /**
     * Get Table Reservation
     * @authenticated
     *
     * @param $id string required
     * @return TableReservationResource
     */
    public function show($id)
    {
        $reservation = $this->tableReservationRepository->findOrFail($id);
        $reservation->load('order.items.orderItems');

        return new TableReservationResource($reservation);
    }
}
