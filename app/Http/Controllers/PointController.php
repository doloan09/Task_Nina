<?php

namespace App\Http\Controllers;

use App\Http\Requests\PointRequest;
use App\Http\Resources\FailedCollection;
use App\Http\Resources\SuccessCollection;
use App\Repositories\Point\PointRepositoryInterface;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PointController extends Controller
{
    protected PointRepositoryInterface $pointRepo;

    public function __construct(PointRepositoryInterface $pointRepo)
    {
        $this->pointRepo = $pointRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return FailedCollection|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $list = $this->pointRepo->getAllPoint($request);

            return Datatables::of($list)
                ->editColumn('action', function ($item) {
                    return '<button class="btn btn-xs btn-warning" data-toggle="modal" data-target="#exampleModal" style="margin: 0px 10px;">Update</button><button onclick="deleteClass('. $item->id .')" class="btn btn-xs btn-danger btn-delete">Delete</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }catch (\Exception $e){
            return new FailedCollection($e);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return FailedCollection|SuccessCollection|\Illuminate\Http\Response
     */
    public function store(PointRequest $request)
    {
        try {
            $data = request(['id_user', 'id_class', 'score_component', 'score_test', 'score_final']);

            $item = $this->pointRepo->create($data);

            return new SuccessCollection($item);
        }catch (\Exception $e){
            return new FailedCollection(collect([$e]));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return FailedCollection|SuccessCollection|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $item = $this->pointRepo->find($id);
            $this->pointRepo->delete($id);

            return new SuccessCollection($item);
        }catch (\Exception $e){
            return new FailedCollection(collect([$e]));
        }
    }

    /**
     * Show the form for list a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function list(){
        return $this->pointRepo->viewList('points.list');
    }
}
