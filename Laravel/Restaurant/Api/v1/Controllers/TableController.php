<?php


namespace App\Modules\Restaurant\Api\v1\Controllers;


use App\Modules\BaseController;
use App\Modules\Restaurant\Api\v1\Requests\CreateTableRequest;
use App\Modules\Restaurant\Api\v1\Requests\StoreTableRequest;
use App\Modules\Restaurant\Api\v1\Requests\UpdateTableRequest;
use App\Modules\Restaurant\Api\v1\Transformers\TableTransformer;
use App\Modules\Restaurant\Models\Seat;
use App\Modules\Restaurant\Repositories\ImageRepository;
use App\Modules\Restaurant\Repositories\SeatRepository;
use App\Modules\Restaurant\Repositories\TableRepository;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\DB;


/**
 *  @group Table Management
 *
 *
 *
 * @package App\Modules\Restaurant\Api\v1\Controllers
 */
class TableController extends BaseController
{

    /**
     * @var TableRepository
     */
    protected $tableRepository;


    /**
     * @var SeatRepository
     */
    protected $seatRepository;


    /**
     * @var TableTransformer
     */
    protected $tableTransformer;



    public function __construct(TableRepository $tableRepository,
                                SeatRepository $seatRepository,
                                TableTransformer $tableTransformer)
    {
       $this->tableRepository = $tableRepository;
       $this->tableTransformer = $tableTransformer;
       $this->seatRepository = $seatRepository;
    }


    /**
     * Create Table
     * @authenticated
     *
     * @bodyParam name string required Table Name
     * @bodyParam type string  required Table Type
     * @bodyParam no_of_seats required number of seats
     * @bodyParam image_id Table Image
     * @bodyParam can_merge boolean required If table can be joint
     *
     *
     *
     * @param CreateTableRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createTable(CreateTableRequest $request){

        $data = $request->validated();


        $table = null;
        DB::transaction(function () use($data, &$table,$request){
            $table = $this->tableRepository->persist($data);
        });


        return $this->transform($table,$this->tableTransformer);

    }

    /**
     * Create or Update Table
     * @authenticated
     *
     * @bodyParam id string optional Id of table, only needed when to update
     * @bodyParam type string  required Table Type in: table, booth, bat
     * @bodyParam no_of_seats unsigned_integer optional Required when creating number of seats
     * @bodyParam section_id string required
     * @bodyParam name string required
     * @bodyParam position object required Object containing the height width and position data
     *
     * @transformer TableTransformer
     */

    public function store(StoreTableRequest $request){

        $data = $request->all();


        $table = $this->tableRepository->updateOrCreate([
            'id' => $data['id'] ?? null,
            'section_id' => $data['section_id'],
            'name' => $data['name'],
//            'no_of_seats' => $data['no_of_seats'],
            'type' => $data['type'],
            'position' => $data['position'],
        ]);

        if (isset($data['no_of_seats']) && ! isset($data['id']))
        {
            $counter = 1;
            for ($counter; $counter <= $data['no_of_seats']; $counter++)
            {
                $this->seatRepository->persist([
                    'table_id' => $table->id,
                    'name' => "S$counter"
                ]);
            }
        }
        return $this->transform($table,$this->tableTransformer);

    }


    /**
     * List tables
     * @authenticated
     *
     * @param Request $request
     * @transformerCollection TableTransformer
     */
    public function listTables(Request $request){

        $tables = $this->tableRepository->getTables();

        return $this->transform($tables, $this->tableTransformer);

    }


    /**
     * Update Table
     * @authenticated
     *
     * @bodyParam id string  required Table id
     * @bodyParam name string Table Name
     * @bodyParam type string Table Type
     * @bodyParam no_of_seats number of seats
     * @bodyParam image_id Table Image
     * @bodyParam can_join boolean If table can be joint
     *
     *
     *
     * @param UpdateTableRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
   public function updateTable(UpdateTableRequest $request){

        $data = $request->all();

       $image = $this->imageRepository->findById($request->image_id);
       if ($image)
           $data['image'] = $image->image;

        if(!empty($data['name']) && $this->tableRepository->tableExistId($data['name'],$data['id'])){
            return $this->error('Table already exist', 422);
        }

       $updated =  $this->tableRepository->update($data['id'], $data);

       if($updated){
           $table = $this->tableRepository->findById($data['id']);
           return  $this->transform($table, $this->tableTransformer);
       }

       return $this->fail('Table update failed', 422);

   }


    /**
     * Delete Table
     * @authenticated
     *
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
   public function deleteTable($id){


       if(!$this->tableRepository->findById($id)){
           return $this->fail('Can not delete table does not exist', 404);
       }

       $deleted = $this->tableRepository->delete($id);

       if($deleted){
           return $this->success(['message' => 'Table deleted successfully']);
       }


       return $this->fail('Table delete failed', 404);
   }
}
