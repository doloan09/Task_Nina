<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubjectRequest;
use App\Http\Resources\FailedCollection;
use App\Http\Resources\SuccessCollection;
use App\Repositories\Subject\SubjectRepositoryInterface;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SubjectController extends Controller
{
    protected SubjectRepositoryInterface $subjectRepo;

    public function __construct(SubjectRepositoryInterface $subjectRepo)
    {
        $this->subjectRepo = $subjectRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return FailedCollection|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $list = $this->subjectRepo->getAll();

            return Datatables::of($list)
                ->editColumn('action', function ($item) {
                    return '<button class="btn btn-xs btn-warning" data-toggle="modal" data-target="#exampleModal" style="margin: 0px 10px;">Update</button><button onclick="deleteSub('. $item->id .')" class="btn btn-xs btn-danger btn-delete">Delete</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }catch (\Exception $e){
            return new FailedCollection(collect([$e]));
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
    public function store(SubjectRequest $request)
    {
        try {
            $data = request(['name_subject', 'code_subject', 'number_of_credits']);

            $item = $this->subjectRepo->create($data);

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
     * @return FailedCollection|SuccessCollection|\Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();

            $item = $this->subjectRepo->update($id, $data);
            return new SuccessCollection($item);
        }catch (\Exception $e){
            return new FailedCollection(collect([$e]));
        }
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
            $item = $this->subjectRepo->find($id);
            $this->subjectRepo->delete($id);

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
        return $this->subjectRepo->viewList('subjects.list');
    }
}