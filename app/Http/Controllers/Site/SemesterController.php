<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\SemesterRequest;
use App\Http\Resources\FailedCollection;
use App\Http\Resources\SuccessCollection;
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

            return Datatables::of($list)
                ->editColumn('action', function ($item) {
                    $name  = "'" . $item->name_semester . "'";
                    $year  = "'" . $item->year_semester . "'";
                    $start = "'" . $item->start_time . "'";
                    $end   = "'" . $item->end_time . "'";
                    return '<button onclick="setValue(' . $item->id . ', ' . $name . ', ' . $year . ', ' . $start . ', ' . $end . ')" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#createSemester" style="margin: 0px 20px;">Sửa</button><button onclick="deleteSemester(' . $item->id . ')" class="btn btn-xs btn-danger btn-delete">Xóa</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        } catch (\Exception $e) {
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
     * @param \Illuminate\Http\Request $request
     * @return FailedCollection|SuccessCollection|\Illuminate\Http\Response
     */
    public function store(SemesterRequest $request)
    {
        try {
            $data = request(['name_semester', 'year_semester', 'start_time', 'end_time']);

            $item = $this->semesterRepo->createSemester($data);

            if (!$item){
                return new FailedCollection(collect([]));
            }

            return new SuccessCollection($item);
        } catch (\Exception $e) {
            return new FailedCollection(collect([$e]));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return FailedCollection|SuccessCollection|\Illuminate\Http\Response
     */
    public function update(SemesterRequest $request, $id)
    {
        try {
            $data = $request->all();

            $user = $this->semesterRepo->updateSemester($data, $id);

            if (!$user){
                return new FailedCollection(collect([]));
            }

            return new SuccessCollection($user);
        } catch (\Exception $e) {
            return new FailedCollection(collect([$e]));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return FailedCollection|SuccessCollection|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $item = $this->semesterRepo->find($id);
            $this->semesterRepo->delete($id);

            return new SuccessCollection($item);
        } catch (\Exception $e) {
            return new FailedCollection(collect([$e]));
        }
    }


    /**
     * Show the form for list a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function list()
    {
        return $this->semesterRepo->viewList('semesters.list');
    }
}
