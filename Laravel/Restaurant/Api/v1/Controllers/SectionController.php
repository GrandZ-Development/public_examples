<?php


namespace App\Modules\Restaurant\Api\v1\Controllers;


use App\Modules\BaseController;
use App\Modules\Restaurant\Api\v1\Transformers\SectionTableTransformer;
use App\Modules\Restaurant\Repositories\SectionRepository;
use Dingo\Api\Http\Request;
use Dingo\Blueprint\Annotation\Method\Delete;
use Illuminate\Support\Str;

/**
 * @group Section Management
 * Class SectionController
 * @package App\Modules\Restaurant\Api\v1\Controllers
 */
class SectionController extends BaseController
{

    /**
     * @var SectionRepository
     */
    protected $sectionRepository;


    /**
     * @var SectionTableTransformer
     */
    protected $sectionTransformer;


    public function __construct(SectionRepository $sectionRepository, SectionTableTransformer $sectionTransformer)
    {
        $this->sectionRepository = $sectionRepository;
        $this->sectionTransformer = $sectionTransformer;
    }

    /**
     * Create or Update Section
     * @authenticated
     *
     * @bodyParam id string optional Id of section, only needed when to update
     * @bodyParam name string required Section Name
     * @bodyParam floor_id string required Floor Id
     *
     *
     *
     * @param Request $request
     * @transformer SectionTableTransformer
     */
    public function store(Request $request){

        $request->validate([
            'id' => 'nullable|exists:sections',
            'name' => 'required',
            'floor_id' => 'required|exists:floors,id'
        ]);

        $section = $this->sectionRepository->updateOrCreate([
            'id' => $request->id ?? null,
            'name' => $request->name,
            'floor_id' => $request->floor_id
        ]);

        return  $this->transform($section, $this->sectionTransformer);

    }


    /**
     * List Sections
     * @authenticated
     *
     *
     * @transformerCollection SectionTableTransformer
     */
    public function listSections(){
        $sections = $this->sectionRepository->get();

        return $this->transform($sections, $this->sectionTransformer);
    }


    /**
     * Delete Section
     * @authenticated
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteSection(string $id){

        if(!$this->sectionRepository->findById($id)){
            return $this->error('Section not found', 404);
        }


        $deleted = $this->sectionRepository->delete($id);

        if($deleted){
            return  $this->success(['message' => 'Section deleted successfully']);
        }


        return $this->error('Unable to delete section', 500);
    }


    /**
     * Add Table
     * @authenticated
     *
     *
     * @bodyParam section_id string required Section  id
     * @bodyParam table_id string require Table id
     *
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addTable(Request $request){

        $data = $request->validate([
            'section_id'  => 'required|exists:sections,id',
            'table_id'       =>  'required|exists:tables,id'
        ]);

        $sectionTable =  $this->sectionRepository->addTable($data);
        $section = $this->sectionRepository->findById($sectionTable->section_id);

        return $this->transform($section, $this->sectionTransformer);
    }


    /**
     * Remove Table
     * @authenticated
     *
     *
     * @bodyParam section_id string required Section  id
     * @bodyParam table_id string require Table id
     *
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeTable(Request $request){

        $data = $request->validate([
            'section_id'  => 'required|exists:sections,id',
            'table_id'       =>  'required|exists:tables,id'
        ]);

        if(!$this->sectionRepository->getTableSection($data['table_id'], $data['section_id'])){
            return $this->error('Table not found in section');
        }


        $deleted =  $this->sectionRepository->removeTable($data);
        if($deleted){
            return  $this->success(['message' => 'Table deleted successfully']);
        }
        $section = $this->sectionRepository->findById($data['section_id']);

        return $this->transform($section, $this->sectionTransformer);
    }



}
