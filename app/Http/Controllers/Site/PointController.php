<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
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
                ->editColumn('code_class', function ($item) {
                    return $item->code_class;
                })
                ->editColumn('action', function ($item) {

                    return '<button onclick="update('. $item->id .')" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#createPoint" style="margin: 0px 10px;">Update</button>
                            <button onclick="deleteClass('. $item->id .')" class="btn btn-xs btn-danger btn-delete">Delete</button>';
                })
                ->rawColumns(['code_class', 'action'])
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
            $score_component = $request->get('score_component');
            $score_test = $request->get('score_test');
            $score_final = $request->get('score_final');
            $error = [];

            if ($score_component > 10 || $score_component < 0){
                $error['score_component'] = 'Điểm thành phần không hợp lệ!';
            }
            if ($score_test > 10 || $score_test < 0){
                $error['score_component'] = 'Điểm thi không hợp lệ!';
            }
            if ($score_final > 10 || $score_final < 0){
                $error['score_component'] = 'Điểm tổng kết không hợp lệ!';
            }

            if (count($error)){
                return new FailedCollection(collect([$error]));
            }

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
     * @return FailedCollection|SuccessCollection|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $item = $this->pointRepo->find($id);

            return response()->json(['data' => $item, 'status' => 200]);
        }catch (\Exception $e){
            return new FailedCollection(collect([$e]));
        }
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

            $item = $this->pointRepo->update($id, $data);
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
