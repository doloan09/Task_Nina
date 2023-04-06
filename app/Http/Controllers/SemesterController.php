<?php

namespace App\Http\Controllers;

use App\Http\Resources\FailedCollection;
use App\Repositories\Semester\SemesterRepositoryInterface;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SemesterController extends Controller
{
    protected SemesterRepositoryInterface $semesterRepo;

    public function __construct(SemesterRepositoryInterface $semesterRepo)
    {
        $this->semesterRepo = $semesterRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return FailedCollection|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $list = $this->semesterRepo->getAll();

            return DataTables::of($list)->make(true);
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * Show the form for list a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function list(){
        return $this->semesterRepo->viewList('semesters.list');
    }
}
