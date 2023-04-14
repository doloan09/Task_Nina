<?php

namespace App\Http\Controllers\Site;

use App\Exports\PointExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\PointRequest;
use App\Http\Resources\FailedCollection;
use App\Http\Resources\SuccessCollection;
use App\Imports\PointImport;
use App\Models\Class_HP;
use App\Models\Point;
use App\Models\User;
use App\Repositories\Point\PointRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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

                    return '<button onclick="update('. $item->id .')" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#createPoint" style="margin: 0px 20px;">Sửa</button>
                            <button onclick="deleteClass('. $item->id .')" class="btn btn-xs btn-danger btn-delete">Xóa</button>';
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

            $item = Point::query()->where('id_user', $request->get('id_user'))->where('id_class', $request->get('id_class'))->first();
            if ($item){
                $error['point_unique'] = 'Đã tồn tại điểm của sinh viên với môn học';
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

    public function import(Request $request){
        $validator = Validator::make($request->all(), [
            'file' => 'required',
        ]);
        if ($validator->fails()) {
            // Bad Request
            return response()->json(['err' => $validator->getMessageBag(), 'status' => 404]);
        }
        $import = new PointImport();
        $import->import($request->file);
        if (!$import->failures()->isNotEmpty() && count($import->Err) == 0) {
            return response()->json(['status' => 200]);
        } else {
            $errors = [];
            $errorsData = [];
            foreach ($import->failures() as $value) { // loi khi validate
                $errors[] = ['row' => $value->row(), 'err' => $value->errors()];
            }
            foreach ($import->Err as $value) {
                $errorsData[] = ['row' => $value['row'], 'err' => $value['err']];
            }
            return response()->json(['status' => 500, 'Err_Message' => 'Dữ liệu đầu vào có lỗi!', 'err' => $errors, 'errData' => $errorsData]);
        }
    }

    public function export(Request $request)
    {
        try {
            $name = 'bang_diem.xlsx';

            if ($request->query('id_class')){
                $class = Class_HP::query()->select('name_class', 'code_class')->where('id', $request->query('id_class'))->first();
                $name = 'bang_diem_' . $class['name_class'] . '_' . $class['code_class'];
            }
            else if ($request->query('code_user')){
                $user = User::query()->select('name', 'code_user')->where('code_user', $request->query('code_user'))->first();
                $name = 'bang_diem_' . $user['name'] . '_' . $request->query('code_user');
            }

            $name .= '.xlsx';

            return (new PointExport($request))->download($name);
        }catch (\Exception $exception){
            $message = 'Error';
            return view('points.list', compact('message'));
        }
    }
}
